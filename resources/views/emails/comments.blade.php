@component('mail::message')
# New Comment,

A new comment has been posted by {{ $user->getRoleNames()->first() }}.

{{$description}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
