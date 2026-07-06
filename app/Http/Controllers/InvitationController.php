<?php

namespace App\Http\Controllers;

use App\Models\TeamInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    public function accept(Request $request, TeamInvitation $invitation)
    {
        // If the user doesn't have an account, redirect them to a special register route
        // and put the invitation ID in session so we can attach them to the team upon registration
        if (!Auth::check()) {
            session(['invitation_id' => $invitation->id]);
            // Redirect to the standard registration page with email prefilled
            return redirect()->route('register', ['email' => $invitation->email]);
        }

        // Validate the invited email matches the authenticated user's email
        // Standard security practice
        if (Auth::user()->email !== $invitation->email) {
            abort(403, 'This invitation is for a different email address.');
        }

        // Add user to team
        $user = Auth::user();
        $invitation->team->members()->attach(
            $user,
            ['role' => $invitation->role]
        );

        if (!$user->current_team_id) {
            $user->update(['current_team_id' => $invitation->team_id]);
        }

        // Mark invitation as accepted or simply delete it
        $invitation->delete();

        // Redirect to dashboard (they now bypass payment screen because they are on a team)
        return redirect()->route('member.dashboard')->with('success', 'You have joined the team!');
    }
}
