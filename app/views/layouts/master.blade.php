<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title')</title>
  {{ HTML::style('css/cnq.css') }}
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:300,700">
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
{{-- HTML::script('js/hyphenate.js') --}}
</html>
