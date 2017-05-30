

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="_token" content="{!! csrf_token() !!}"/>
  <meta http-equiv="refresh" content="300">
 <!--  @yield('title') -->
 <title>Fisher Classic</title>

  <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
  <link href="{{{ asset('/css/main.css') }}}" rel="stylesheet">
  <link href="{{{ asset('/theme/css/bootstrap.css') }}}" rel="stylesheet">
  <link href="{{{ asset('/theme/font-awesome/css/font-awesome.css') }}}" rel="stylesheet">
  <link href="{{{ asset('/theme/css/animate.css') }}}" rel="stylesheet">
  <link href="{{{ asset('/theme/css/style.css') }}}" rel="stylesheet">
  <link href="{{{ asset('theme/css/plugins/sweetalert/sweetalert.css') }}}" rel="stylesheet">
  <link href="{{{ asset('/fonts/blacksword/stylesheet.css') }}}" rel="stylesheet">


  @yield('css')


  <!-- Main scripts -->
  <script src="{{{ asset('/theme/js/jquery-2.1.1.js') }}}"></script>
  <script src="{{{ asset('/theme/js/bootstrap.min.js') }}}"></script>
  <script src="{{{ asset('/theme/js/plugins/metisMenu/jquery.metisMenu.js') }}}"></script>
  <script src="{{{ asset('/theme/js/plugins/slimscroll/jquery.slimscroll.min.js') }}}"></script>
  <script src="{{{ asset('/theme/js/inspinia.js') }}}"></script>
  <script src="{{{ asset('/theme/js/plugins/pace/pace.min.js') }}}"></script>
  <script src="{{{ asset('/theme/js/plugins/sweetalert/sweetalert.min.js') }}}"></script>
  <script src="{{{ asset('/js/mqttws31.js') }}}"></script>
  <script src="{{{ asset('/js/moment.js') }}}"></script>
  

<link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{{ asset('/favicon/apple-touch-icon-57x57.png') }}}" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{{ asset('/favicon/apple-touch-icon-114x114.png') }}}" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{{ asset('/favicon/apple-touch-icon-72x72.png') }}}" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{{ asset('/favicon/apple-touch-icon-144x144.png') }}}" />
<link rel="apple-touch-icon-precomposed" sizes="60x60" href="{{{ asset('/favicon/apple-touch-icon-60x60.png') }}}" />
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{{ asset('/favicon/apple-touch-icon-120x120.png') }}}" />
<link rel="apple-touch-icon-precomposed" sizes="76x76" href="{{{ asset('/favicon/apple-touch-icon-76x76.png') }}}" />
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{{ asset('/favicon/apple-touch-icon-152x152.png') }}}" />
<link rel="icon" type="image/png" href="{{{ asset('/favicon/favicon-196x196.png') }}}" sizes="196x196" />
<link rel="icon" type="image/png" href="{{{ asset('/favicon/favicon-96x96.png') }}}" sizes="96x96" />
<link rel="icon" type="image/png" href="{{{ asset('/favicon/favicon-32x32.png') }}}" sizes="32x32" />
<link rel="icon" type="image/png" href="{{{ asset('/favicon/favicon-16x16.png') }}}" sizes="16x16" />
<link rel="icon" type="image/png" href="{{{ asset('/favicon/favicon-128.png') }}}" sizes="128x128" />
<meta name="application-name" content="&nbsp;"/>
<meta name="msapplication-TileColor" content="#FFFFFF" />
<meta name="msapplication-TileImage" content="mstile-144x144.png" />
<meta name="msapplication-square70x70logo" content="mstile-70x70.png" />
<meta name="msapplication-square150x150logo" content="mstile-150x150.png" />
<meta name="msapplication-wide310x150logo" content="mstile-310x150.png" />
<meta name="msapplication-square310x310logo" content="mstile-310x310.png" />
 
@yield('scripts')


</head>

<body class="" ontouchstart="">

  <div id="wrapper">
      
      @yield('content')

  </div>
<!-- end of wrapper -->

</body>



</html>
