@component('mail::message')
# Hello,

The status has been changed by {{$user->name}} to: {{$content}}.

{{--@component('mail::button', ['url' => ''])--}}
{{--Preview--}}
{{--@endcomponent--}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
