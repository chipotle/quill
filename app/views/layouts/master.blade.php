<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title')</title>
  {{ Html::style('css/cnq.css') }}
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Istok+Web:400,700">
  @yield('head')
</head>

<body>
  <div id="content">
    @yield('content')
  </div>
</body>

</html>
