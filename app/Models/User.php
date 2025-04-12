<?php

namespace App\Models;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\DTOs\Auth\ResetLinkDTO;
use App\DTOs\Auth\TokenPairDTO;
use App\Enums\TokenAbilityEnum;
use App\Exceptions\AccountNotActiveException;
use App\Exceptions\EmailAlreadyVerifiedException;
use App\Exceptions\EmailNotVerifiedException;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\InvalidResetTokenException;
use App\Exceptions\InvalidVerificationCodeException;
use App\Exceptions\VerificationCodeExpiredException;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendPasswordResetLinkJob;
use App\Jobs\SendVerificationEmailJob;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Password;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Socialite\Contracts\User as SocialUser;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string|null $verification_code
 * @property Carbon|null $verification_code_sent_at
 * @property mixed $password
 * @property string|null $provider
 * @property string|null $provider_id
 * @property Carbon|null $last_logged_in_at
 * @property int $active
 * @property int|null $role_id
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    // --------------------------------------------------------
    // Attributes
    // --------------------------------------------------------

    protected $fillable = ['name', 'email', 'password', 'available_designs', 'design_limit_bank', 'subscription_start'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'last_logged_in_at' => 'datetime',
        'verification_code_sent_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // --------------------------------------------------------
    // Static Methods (Factories & Social Authentication)
    // --------------------------------------------------------

    public static function createUser(array $data): User
    {
        $user = self::create($data);
        $user->assignRole(getUserRole());
        return $user;
    }

    public static function findOrCreateFromSocialUser(SocialUser $socialUser, string $provider): self
    {
        return DB::transaction(function () use ($socialUser, $provider) {
            $user = self::firstOrCreate(
                ['email' => $socialUser->getEmail()],
                [
                    'name' => $socialUser->getName(),
                    'password' => bcrypt(Str::random(16)),
                ]
            );

            $user->assignRole(getUserRole());

            if (!$user->email_verified_at) {
                $user->markEmailAsVerified();
            }

            if (!$user->provider || $user->provider !== $provider) {
                $user->updateProviderInfo($provider, $socialUser->getId());
            }

            return $user;
        });
    }

    public static function authenticate(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            throw new InvalidCredentialsException();
        }

        return Auth::user();
    }

    // --------------------------------------------------------
    // Relationships
    // --------------------------------------------------------

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function liked(): BelongsToMany
    {
        return $this->belongsToMany(Design::class, 'likes');
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'user_id');
    }


    // --------------------------------------------------------
    // Scopes
    // --------------------------------------------------------

    public function scopeIsActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    // --------------------------------------------------------
    // Instance Methods (User States)
    // --------------------------------------------------------

    public function isActive(): bool
    {
        return $this->active;
    }

    public function activate(): void
    {
        $this->active = true;
        $this->save();
    }

    public function deactivate(): void
    {
        $this->active = false;
        $this->save();
    }

    public function ensureAccountIsActive(): void
    {
        if (!$this->isActive()) {
            throw new AccountNotActiveException();
        }
    }

    // --------------------------------------------------------
    // Authentication Tokens
    // --------------------------------------------------------

    public function token(): TokenPairDTO
    {
        $this->last_logged_in_at = now();
        $this->save();

        return new TokenPairDTO(
            accessToken: $this->accessToken()->plainTextToken,
            refreshToken: $this->refreshToken()->plainTextToken
        );
    }

    private function accessToken()
    {
        return $this->createToken(
            'access-token',
            [TokenAbilityEnum::ACCESS_TOKEN->value],
            Carbon::now()->addMinutes(config('sanctum.ac_expiration'))
        );
    }

    private function refreshToken()
    {
        return $this->createToken(
            'refresh-token',
            [TokenAbilityEnum::REFRESH_TOKEN->value],
            Carbon::now()->addMinutes(config('sanctum.rt_expiration'))
        );
    }

    // --------------------------------------------------------
    // Email Verification
    // --------------------------------------------------------

    public function markEmailAsVerified(): void
    {
        $this->email_verified_at = now();
        $this->verification_code = null;
        $this->save();
    }

    public function ensureEmailVerified(): void
    {
        if (!$this->email_verified_at) {
            throw new EmailNotVerifiedException();
        }
    }

    public function createVerificationCode(): void
    {
        $this->verification_code = generateVerificationCode();
        $this->verification_code_sent_at = now();
        $this->save();
    }

    public function verifyCodeAndExpiration(string $verificationCode): void
    {
        if ($this->email_verified_at) {
            throw new EmailAlreadyVerifiedException();
        }

        if ($this->verification_code_sent_at->addMinutes(10)->isPast()) {
            $this->createVerificationCode();
            throw new VerificationCodeExpiredException();
        }

        if ($this->verification_code !== $verificationCode) {
            throw new InvalidVerificationCodeException();
        }
    }

    public function sendVerificationEmail(): void
    {
        if ($this->email_verified_at) {
            throw new EmailAlreadyVerifiedException();
        }

        $this->createVerificationCode();
        SendVerificationEmailJob::dispatch($this);
    }

    // --------------------------------------------------------
    // Password Reset
    // --------------------------------------------------------

    public function resetPassword(string $password): void
    {
        $this->password = $password;
        $this->save();
    }

    public function sendResetPasswordEmail(ResetLinkDTO $dto): void
    {
        SendPasswordResetLinkJob::dispatch($dto);
    }

    public function createPasswordResetToken()
    {
        return Password::createToken($this);
    }

    public function validResetToken(string $token): void
    {
        if (!Password::tokenExists($this, $token)) {
            throw new InvalidResetTokenException();
        }
    }

    public function deleteResetToken(): void
    {
        Password::deleteToken($this);
    }

    // --------------------------------------------------------
    // Role Management
    // --------------------------------------------------------

    public function assignRole(Role $role): void
    {
        $this->role_id = $role->id;
        $this->save();
    }

    public function hasRole(Role $role): bool
    {
        return $this->role_id === $role->id;
    }

    // --------------------------------------------------------
    // Third-Party Provider Management
    // --------------------------------------------------------

    public function updateProviderInfo(string $provider, string $providerId): void
    {
        $this->provider = $provider;
        $this->provider_id = $providerId;
        $this->save();
    }
}
