@component('mail::message')
# Account Created

Dear {{ $user->name }} your account has been created on {{ config('app.name') }}.

Login using the details below:
<b>Email: </b>{{ $user->email }}<br>
<b>Password: </b>{{ $password }}

@component('mail::button', ['url' => route('login')])
    Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
