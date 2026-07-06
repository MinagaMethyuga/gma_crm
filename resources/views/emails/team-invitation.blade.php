<x-mail::message>
# You have been invited to join {{ $invitation->team->name }}!

You have been invited to join the **{{ $invitation->team->name }}** team on the GMA Member Portal.

By accepting this invitation, you will receive full access to the member portal through your organization's subscription.

<x-mail::button :url="$acceptUrl">
Accept Invitation
</x-mail::button>

If you do not have an account, you may create one for free when you click the button above.

If you did not expect to receive an invitation to this team, you may discard this email.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
