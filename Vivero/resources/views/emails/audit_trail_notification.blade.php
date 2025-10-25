<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Notificación Interna</title>
</head>
<body>
    <h2>Notificación Interna</h2>

    <p>Se ha detectado la creación de un nuevo cliente en el sistema.</p>

    <div style="border: 1px solid #ccc; padding: 10px;">
        <p><strong>ID Cliente:</strong> {{ $details['cliente_id'] }}</p>
        <p><strong>Nombre:</strong> {{ $details['nombre'] }}</p>
        <p><strong>Email:</strong> {{ $details['email'] }}</p>
        <p><strong>Fecha de creación:</strong> {{ $details['fecha'] }}</p>
        <p><strong>Evento:</strong> {{ $details['evento'] }}</p>
    </div>

    <p>Gracias por tu atención,<br>{{ config('app.name') }}</p>
</body>
</html>
