<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin: @yield('title')</title>
{{ Html::style('css/bootstrap.min.css') }}
@yield('head')
</head>

<body style="padding-top:60px">
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container">
        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        {{ Html::link('sysop', 'Claw &amp; Quill', ['class'=>'brand']) }}
        <div class="nav-collapse collapse">
          <ul class="nav">
            <li>{{ Html::linkRoute('sysop.pages.index', 'Pages') }}</li>
            <li><a href="#">Issues</a></li>
            <li><a href="#">Authors</a></li>
            <li>{{ Html::linkRoute('sysop.pitches.index', 'Pitches') }}</li>
            <li><a href="#">Users</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div id="content" class="container">
    @if (Session::has('msg'))
    <div class="alert">
      {{ Session::get('msg') }}
      <a class="close" data-dismiss="alert" href="#">&times;</a>
    </div>
    @endif
    @if (Session::has('error'))
    <div class="alert alert-error">
      <a class="close" data-dismiss="alert" href="#">&times;</a>
        @foreach (Session::get('error')->all() as $err)
        <i class="icon-exclamation-sign icon-white"></i> {{ $err }}<br>
        @endforeach
    </div>
    @endif
    <h1>@yield('title')</h1>
    <hr>
    @yield('content')
  </div>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  {{ HTML::script('js/bootstrap.min.js') }}
  @yield('scripts')
  <body>
</html>
