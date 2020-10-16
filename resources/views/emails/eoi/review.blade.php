@component('mail::message')
# Hello {{$user->name}}

{{$content}}.

@component('mail::button', ['url' => ''])
Preview
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
