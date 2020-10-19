@component('mail::message')
# Hello {{$wsp->name}}

{{$description}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
