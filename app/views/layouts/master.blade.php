<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="icon" href="/cnq-icon-32.png" sizes="32x32" type="image/png">
  <link rel="icon" href="/favicon.ico" sizes="32x32" type="image/vnd.microsoft.icon">
  <link rel="apple-touch-icon" href="/cnq-icon.png">
  <title>@yield('title')</title>
  {{ HTML::style('css/cnq.css') }}
  <script type="text/javascript" src="//use.typekit.net/fky8rov.js"></script>
  <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
  @yield('head')
</head>

<body>
  <div id="content">
    @if (Session::has('msg'))
    <div class="alert">
      {{ Session::get('msg') }}
    </div>
    @endif
    @if (Session::has('error'))
    <div class="alert error">
      @foreach (Session::get('error')->all() as $err)
      {{ $err }}<br>
      @endforeach
    </div>
    @endif

    @yield('content')
  </div>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  {{ HTML::script('js/cnq.js') }}
</body>
</html>
