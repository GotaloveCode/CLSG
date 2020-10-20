@component('mail::message')
# Review,

The status has been changed by {{ $user->getRoleNames()->first() }} to: {{$status}}.

@component('mail::button', ['url' => $route])
Preview
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
