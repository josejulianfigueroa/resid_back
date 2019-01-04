@component('mail::message')
# Change password Request

Click sobre el bot+on de abajo para cambiar el password

@component('mail::button', ['url' => 'http://localhost:4201/#/response-password-reset?token='.$token])
Reset Password
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
