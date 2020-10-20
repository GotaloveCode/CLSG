@component('mail::message')
# Hello,

{{$description}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
