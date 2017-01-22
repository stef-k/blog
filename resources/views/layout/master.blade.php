<!DOCTYPE html>
<html lang="en">
<head itemscope itemtype="http://schema.org/WebSite">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('og')
    <link rel="icon" href="{{ asset('img/icon.png') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ elixir('css/app.css')  }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/styles/vs.min.css">
    <title itemprop='name'> @yield('title') </title>
    <link rel="canonical" href="{{url('/')}}" itemprop="url">
    <script>
      window.myapp = window.myapp  || {};
      window.myapp.trackingId = '{{$settings->tracking_id}}';
      window.myapp.disqusUrl = '{{$settings->disqus_url}}';
    </script>
</head>
<body class="site">

@include('layout.nav')

@yield('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/highlight.min.js"></script>
<script src="{{ elixir('js/public.js')  }}"></script>
</body>
</html>
