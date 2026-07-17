<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Concerns\HasTeams;
use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\PasskeyUser;
use Laravel\Fortify\PasskeyAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property Carbon|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property UserRole $role
 * @property string|null $phone
 * @property string|null $company_name
 * @property string|null $industry
 * @property string|null $job_title
 * @property int|null $plan_id
 * @property Carbon|null $plan_subscribed_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Team|null $currentTeam
 * @property-read Collection<int, Team> $ownedTeams
 * @property-read Collection<int, Membership> $teamMemberships
 * @property-read Collection<int, Team> $teams
 * @property-read Plan|null $plan
 */
#[Fillable(['name', 'email', 'avatar', 'password', 'current_team_id', 'role', 'phone', 'company_name', 'industry', 'job_title', 'plan_id', 'plan_subscribed_at', 'physical_address', 'company_website', 'country', 'referral_code', 'referred_by'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable implements PasskeyUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasTeams, Notifiable, PasskeyAuthenticatable, TwoFactorAuthenticatable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
            'role' => UserRole::class,
            'plan_subscribed_at' => 'datetime',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isMember(): bool
    {
        return $this->role === UserRole::Member;
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public static function generateReferralCode(): string
    {
        return strtoupper(Str::random(8));
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        $initials = Str::initials($this->name, true);

        return Str::length($initials) > 1
            ? Str::substr($initials, 0, 1).Str::substr($initials, -1)
            : $initials;
    }

    public function avatarUrl(): string
    {
        if ($this->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/' . $this->avatar);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name ?? 'User') . '&background=103C68&color=fff';
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatarUrl();
    }

    public function daysUntilPlanExpiry(): ?int
    {
        if (! $this->plan_subscribed_at) {
            return null;
        }
        $expiryDate = $this->plan_subscribed_at->copy()->addYear();
        return (int) now()->diffInDays($expiryDate, false);
    }

    public function isPlanExpired(): bool
    {
        if ($this->isAdmin()) {
            return false;
        }

        if (! $this->plan_id || ! $this->plan_subscribed_at) {
            return true;
        }

        return $this->daysUntilPlanExpiry() < 0;
    }

    public function isNearExpiry(): bool
    {
        if ($this->isAdmin()) {
            return false;
        }

        $days = $this->daysUntilPlanExpiry();
        if ($days === null) {
            return false;
        }

        return $days >= 0 && $days <= 30;
    }

    public function hasActiveMembership(): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (!$this->isPlanExpired()) {
            return true;
        }

        if ($this->teams()->where('subscription_status', 'active')->exists()) {
            return true;
        }

        // Check if user belongs to a team whose owner has an active personal membership
        foreach ($this->teams as $team) {
            $owner = $team->owner();
            if ($owner && $owner->id !== $this->id && !$owner->isPlanExpired()) {
                return true;
            }
        }

        return false;
    }

    public function effectivePlanId(): ?int
    {
        if ($this->plan_id) {
            return $this->plan_id;
        }

        foreach ($this->teams as $team) {
            $owner = $team->owner();
            if ($owner && $owner->plan_id) {
                return $owner->plan_id;
            }
        }

        return null;
    }

    public function canInviteMoreMembers(): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (! $this->plan) {
            return false;
        }

        $team = $this->currentTeam;
        if (! $team) {
            return false;
        }

        // Count current users (excluding owner) and pending invitations
        $memberCount = $team->members()->count();
        $invitationsCount = $team->invitations()->count();
        
        // team_limit includes the owner. So if limit is 5, they can have 1 owner + 4 members.
        // The members() relationship gets all members (including owner if they are in the pivot, or maybe not).
        // Let's count total users safely.
        $totalMembers = $team->members()->count();

        return ($totalMembers + $invitationsCount) < $this->plan->team_limit;
    }
}

