<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Fisher Classic</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href="{{{ asset('/css/main.css') }}}" rel="stylesheet">
        <link href="{{{ asset('/theme/css/bootstrap.css') }}}" rel="stylesheet">
        <link href="{{{ asset('/theme/font-awesome/css/font-awesome.css') }}}" rel="stylesheet">
<!--         <link href="{{{ asset('/theme/css/animate.css') }}}" rel="stylesheet"> -->
        <link href="{{{ asset('/theme/css/style.css') }}}" rel="stylesheet">
        <link href="{{{ asset('/fonts/blacksword/stylesheet.css') }}}" rel="stylesheet">
        <link href="{{{ asset('/addtohomescreen/style/addtohomescreen.css') }}}" rel="stylesheet" type="text/css" >
        

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

    </head>

    <style>
        @keyframes animatedBackground {
            from { background-position: 0 0; }
            to { background-position: 100% 0; }
        }
        .header-area{
          /*  border:1px solid red;*/
            position:absolute;
            top:0;
            left:0;
            width: 100%; 
            height:100px;
            background-color: transparent;
            background-image: url('images/clouds.png');
            background-position: bottom;
            background-repeat: repeat-x;
            background-size: contain;
            animation: animatedBackground 10s linear infinite;
            z-index:-1;
        }
        .footer-area{
          /*  border:1px solid red;*/
            position:absolute;
            bottom:0;
            left:0;
            width: 100%; 
            height:100px;
            background-color: transparent;
/*            background-image: url('images/golf-ball-grass.png');*/
            background-position: bottom;
            background-repeat: repeat-x;
            background-size: contain;
            z-index:-1;
        }

    </style>

        <body class="gray-bg" ontouchstart="">
         <!--    <div class="header-area"></div> -->
            <div class="middle-box text-center loginscreen" style="margin-top:0%;">
                <div>
<!--                     <div>
                        <a href="leaderboard" ><h1 class="logo-name fc-font" style="font-size:100px;">FC</h1></a>
                    </div> -->

                    <h3 class="fc-font" style="font-size:40px;">Spring Scramble</h3>
                    <br/>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-refresh"></i> Reset Password
                                </button>
                            </div>
                        </div>
                    </form>

                   <!--  <p class="m-t"> <small>Developed by Matt Glover &copy; 2018<br/>All Rights Reserved</small> </p> -->
                </div>
            </div>
            <div class="footer-area"></div>

        </body>

    <!-- Main scripts -->
    <script src="{{ asset('/theme/js/jquery-2.1.1.js') }}"></script>
    <script src="{{ asset('/theme/js/bootstrap.min.js') }}"></script>
    
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('/theme/js/inspinia.js') }}"></script>
    <script src="{{ asset('/theme/js/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('/addtohomescreen/src/addtohomescreen.js') }}"></script>

    <script>
        // addToHomescreen.removeSession();
        // addToHomescreen({
        //     maxDisplayCount:5,
        //     displayPace: 20,
        // });
    </script>
</html>
