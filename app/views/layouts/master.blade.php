<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
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
</body>
</html>
