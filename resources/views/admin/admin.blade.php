<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ elixir('img/icon.png') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ elixir('css/app.css')  }}">
    <title> @yield('title') </title>
</head>
<body class="site">
<div class="m-t-l"></div>
@include('layout.nav')
<div id="app">
    <dashboard></dashboard>
</div>
<script>
  window.myapp = app || {};
  window.myapp.url = "{!! env('APP_URL') !!}";
</script>
@if(auth()->check())
    <script>
        window.myapp.token = '{{auth()->user()->api_token}}';
    </script>
@endif
<script src="{{ elixir('js/public.js')  }}"></script>
<script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>
<script src="{{ elixir('js/app.js')  }}"></script>
</body>
</html>
