<?php

namespace App\Models;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\DTOs\Auth\RegisterDTO;
use App\DTOs\Auth\ResetLinkDTO;
use App\Exceptions\EmailAlreadyVerifiedException;
use App\Exceptions\EmailNotVerifiedException;
use App\Exceptions\InvalidVerificationCodeException;
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
use App\Exceptions\VerificationCodeExpiredException;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $verification_code
 * @property \Illuminate\Support\Carbon|null $verification_code_sent_at
 * @property mixed $password
 * @property string|null $provider
 * @property string|null $provider_id
 * @property \Illuminate\Support\Carbon|null $last_logged_in_at
 * @property int $active
 * @property int|null $role_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Role|null $role
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static Builder|User isActive()
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User onlyTrashed()
 * @method static Builder|User query()
 * @method static Builder|User whereActive($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLastLoggedInAt($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereProvider($value)
 * @method static Builder|User whereProviderId($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereRoleId($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereVerificationCode($value)
 * @method static Builder|User whereVerificationCodeSentAt($value)
 * @method static Builder|User withTrashed()
 * @method static Builder|User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    // --------------------------------------------------------
    // ATTRIBUTES
    // --------------------------------------------------------

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_logged_in_at' => 'datetime',
        'verification_code_sent_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // --------------------------------------------------------
    // INIT
    // --------------------------------------------------------

    public static function createUser(array $data): User
    {
        $user = User::create($data);
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



    // --------------------------------------------------------
    // RELATIONSHIPS
    // --------------------------------------------------------

    /**
     * Get the role that owns the User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // --------------------------------------------------------
    // SCOPES
    // --------------------------------------------------------

    /**
     * Scope for active users.
     */
    public function scopeIsActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    // --------------------------------------------------------
    // INSTANCE METHODS
    // --------------------------------------------------------

    /**
     * Check if the user is active.
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Securely set the active flag.
     */
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

    public function token()
    {
        $this->last_logged_in_at = now();
        $this->save();
        return $this->createToken('auth_token')->plainTextToken;
    }

    public function updateProviderInfo(string $provider, string $providerId): void
    {
        $this->provider = $provider;
        $this->provider_id = $providerId;
        $this->save();
    }

    public function markEmailAsVerified(): void
    {
        $this->email_verified_at = now();
        $this->verification_code = null;
        $this->save();
    }

    private function createVerificationCode(): void
    {
        $this->verification_code = generateVerificationCode();
        $this->verification_code_sent_at = now();
        $this->save();
    }

    public function createPasswordResetToken()
    {
        return Password::createToken($this);
    }

    // --------------------------------------------------------
    // ROLE MANAGEMENT
    // --------------------------------------------------------

    /**
     * Assign a role to the user.
     *
     * @param int $roleId
     * @return void
     */
    public function assignRole(Role $role): void
    {
        $this->role_id = $role->id;
        $this->save();
    }

    /**
     * Check if the user has a specific role.
     *
     * @param int $roleId
     * @return bool
     */
    public function hasRole(Role $role): bool
    {
        return $this->role_id === $role->id;
    }

    // --------------------------------------------------------
    // VERIFICATION CODE METHODS
    // --------------------------------------------------------

    /**
     * Send the verification email to the user.
     *
     * @throws \Exception
     * @return void
     */
    public function sendVerificationEmail()
    {
        if ($this->email_verified_at)
            throw new EmailAlreadyVerifiedException();
        $this->createVerificationCode();
        SendVerificationEmailJob::dispatch($this);
    }

    /**
     * Check if the verification code is valid and not expired.
     *
     * @param  string  $verificationCode
     * @return void
     * @throws \Exception
     */
    public function verifyCodeAndExpiration(string $verificationCode): void
    {
        if ($this->email_verified_at)
            throw new EmailAlreadyVerifiedException();

        if ($this->verification_code_sent_at->addMinutes(10)->isPast()) {
            $this->sendVerificationEmail();
            throw new VerificationCodeExpiredException();
        }

        if ($this->verification_code !== $verificationCode) {
            throw new InvalidVerificationCodeException();
        }
    }

    public function sendResetPasswordEmail(ResetLinkDTO $dto): void
    {
        if (!$this->email_verified_at)
            throw new EmailNotVerifiedException();
        SendPasswordResetLinkJob::dispatch($dto);
    }

    // --------------------------------------------------------
    // Exceptions
    // --------------------------------------------------------
}
