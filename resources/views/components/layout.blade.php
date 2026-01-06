<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Sistema KBPS' }}</title>
</head>
<body>

<h1> {{ $encabezado ?? 'Título General' }} </h1>

<main>
    {{ $slot }}
</main>

<footer> <b> Pie de Pagina </b> </footer>
</body>
</html>
