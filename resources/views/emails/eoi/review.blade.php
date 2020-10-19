@component('mail::message')
# Hello {{$user->name}}

The status has been changed to: {{$content}}.

{{--@component('mail::button', ['url' => ''])--}}
{{--Preview--}}
{{--@endcomponent--}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
