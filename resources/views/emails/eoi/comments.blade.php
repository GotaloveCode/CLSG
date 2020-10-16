@component('mail::message')
# Hello {{$user->name}}

{{$description}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
