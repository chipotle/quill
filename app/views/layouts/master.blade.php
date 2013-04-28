<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title')</title>
  {{ Html::style('cnq.css') }}
  @yield('head')
</head>

<body>
  <div id="content">
    @yield('content')
  </div>
</body>

</html>
