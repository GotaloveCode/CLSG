@component('mail::message')
# Account Registered

Your company {{ $wsp->name }} has been successfully registered.

Login using the details below:

<b>Email: </b>{{ $wsp->email }}<br>
<b>Password: </b>{{ $password }}

@component('mail::button', ['url' => route('login')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
