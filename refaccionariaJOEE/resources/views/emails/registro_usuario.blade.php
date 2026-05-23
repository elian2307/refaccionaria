@component('mail::message')
# ¡Bienvenido a Subastas JOEE!

Hola {{ $user->nombre }} {{ $user->apellidos }}.

Tu cuenta fue creada correctamente con el correo **{{ $user->email }}**.

Desde ahora puedes entrar a la plataforma para participar en subastas, publicar solicitudes o revisar tus órdenes según tu tipo de usuario.

@component('mail::button', ['url' => config('app.url')])
Entrar a Subastas JOEE
@endcomponent

Gracias por registrarte,<br>
{{ config('app.name') }}
@endcomponent