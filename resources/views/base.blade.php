<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sciice</title>
    @resource(style)
    <script>
        window.routerBase = "/{{ config('sciice.path') }}/";
        window.token = "{{ csrf_token() }}";
    </script>
</head>
<body>

<div id="root"></div>

@resource(script)
@resource(component)
</body>
</html>
