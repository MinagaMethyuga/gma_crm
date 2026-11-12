<?php

namespace App\Actions\Fortify;

use App\Actions\Community\JoinOfficialGroup;
use App\Actions\Teams\CreateTeam;
use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Enums\UserRole;
use App\Models\TeamInvitation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    public function __construct(private CreateTeam $createTeam, private JoinOfficialGroup $joinOfficialGroup)
    {
        //
    }

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            ...$this->organizationRules(required: true),
            'password' => $this->passwordRules(),
        ])->validate();

        return DB::transaction(function () use ($input) {
            $referralCode = User::generateReferralCode();

            $referredBy = null;
            if (session()->has('referral_code')) {
                $referrer = User::where('referral_code', session('referral_code'))->first();
                if ($referrer) {
                    $referredBy = $referrer->id;
                }
                session()->forget('referral_code');
            }

            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => $input['password'],
                'role' => UserRole::Member,
                'phone' => $input['phone'],
                'company_name' => $input['company_name'],
                'industry' => $input['industry'],
                'job_title' => $input['job_title'] ?? null,
                'physical_address' => $input['physical_address'],
                'company_website' => $input['company_website'],
                'country' => $input['country'],
                'referral_code' => $referralCode,
                'referred_by' => $referredBy,
            ]);

            if (session()->has('invitation_id')) {
                $invitation = TeamInvitation::find(session('invitation_id'));
                if ($invitation && $invitation->email === $user->email) {
                    $invitation->team->members()->attach(
                        $user,
                        ['role' => $invitation->role]
                    );
                    $user->update(['current_team_id' => $invitation->team_id]);
                    $invitation->delete();
                }
                session()->forget('invitation_id');
            }

            $this->joinOfficialGroup->handle($user);

            return $user;
        });
    }
}
