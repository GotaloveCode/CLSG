@component('mail::message')
# New Comment,

A new comment has been posted by {{ $user->getRoleNames()->first() }}.

{!! $description !!}

@component('mail::button', ['url' => $route])
    View
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent






