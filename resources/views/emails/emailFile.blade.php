<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Proyecto {{ $nombre }}</title>
</head>
<body>
<p>
    Abajo encontrarás la URL para visualizar el archivo en Dropbox del Trabajo especial de Grado: <b>{{ $nombre }}</b>.
</p>
<p>
    Tendrás la opción de visualizarlo directamente en Dropbox, añadirlo a tu cuenta personal de Dropbox o descargarlo.
</p>
<p>
    <a href="{{ $url }}" target="_blank">{{ $url }}</a>
</p>
</body>
</html>