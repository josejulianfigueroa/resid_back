@component('mail::message')

# Solicitud de Cambio de Password

Click sobre el botón de abajo para cambiar el password

@component('mail::button', ['url' => 'http://localhost:4500/#/response-password-reset?token='.$token.'&email='.$email])
Reset Password
@endcomponent

Gracias<br>
Visita www.residenciaselcristo.com.ve
@endcomponent
