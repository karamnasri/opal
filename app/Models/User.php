<?php

namespace App\Models;

use App\DTOs\Auth\RegisterDTO;
use App\Exceptions\VerificationCodeExpiredException;
use App\Jobs\SendVerificationEmailJob;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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

    /**
     * Verify the user's email.
     *
     * @return void
     */
    public function markEmailAsVerified(): void
    {
        $this->email_verified_at = now();
        $this->verification_code = null;
        $this->save();
    }

    /**
     * Generate and update a new verification code.
     *
     * @return void
     */
    private function createVerificationCode(): void
    {
        $this->verification_code = generateVerificationCode();
        $this->verification_code_sent_at = now();
        $this->save();
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
     * Verify the user's email.
     *
     * @return void
     */
    private function EmailNotVerified(): void
    {
        if (!is_null($this->email_verified_at)) {
            throw new \Exception('Email has already been Verified.');
        }
    }

    /**
     * Check if enough time has passed to resend the verification email.
     *
     * @return bool
     */
    private function canResendVerificationEmail(): bool
    {
        if (is_null($this->verification_code_sent_at))
            return true;


        return $this->verification_code_sent_at->addMinute()->isPast();
    }

    /**
     * Send the verification email to the user.
     *
     * @throws \Exception
     * @return void
     */
    public function sendVerificationEmail(): void
    {
        $this->EmailNotVerified();

        if (!$this->canResendVerificationEmail()) {
            throw new \Exception('Verification email has already been sent. Please wait before sending another.');
        }

        $this->createVerificationCode();

        // Dispatch the job to send the verification email
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
        $this->EmailNotVerified();

        if ($this->verification_code !== $verificationCode) {
            throw new \Exception('Invalid verification code.');
        }

        if ($this->verification_code_sent_at->addMinutes(10)->isPast()) {
            throw new VerificationCodeExpiredException();
        }
    }
}
