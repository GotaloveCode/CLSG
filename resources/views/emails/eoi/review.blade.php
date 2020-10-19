@component('mail::message')
# Hello {{$wsp->name}}

The status has been changed by {{$user->name}} to: {{$content}}.

{{--@component('mail::button', ['url' => ''])--}}
{{--Preview--}}
{{--@endcomponent--}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
