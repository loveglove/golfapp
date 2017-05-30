<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Fisher Classic</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href="{{{ asset('/css/main.css') }}}" rel="stylesheet">
        <link href="{{{ asset('/theme/css/bootstrap.css') }}}" rel="stylesheet">
        <link href="{{{ asset('/theme/font-awesome/css/font-awesome.css') }}}" rel="stylesheet">
        <link href="{{{ asset('/theme/css/animate.css') }}}" rel="stylesheet">
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

        <body class="gray-bg" ontouchstart="">

            <div class="middle-box text-center loginscreen animated fadeIn" style="margin-top:10%;">
                <div>
                    <div>
                        <a href="leaderboard" ><h1 class="logo-name fc-font" style="font-size:135px;">FC</h1></a>
                    </div>
                    <h3 class="fc-font" style="font-size:40px;">Fisher Classic</h3>
                    <p>The 2016 annual Fisher Classic golf tournament. Login with facebook to enter.
                    </p>
                    <a href="auth/facebook" class="form-group"><button type="submit" class="btn btn-primary block full-width m-b dim"><i class="fa fa-facebook"></i>  Login with facebook</button></a>

                    <p class="m-t"> <small>Developed by Matt Glover &copy; 2016<br/>All Rights Reserved</small> </p>
                </div>
            </div>

        </body>

        <!-- Main scripts -->
    <script src="{{{ asset('/theme/js/jquery-2.1.1.js') }}}"></script>
    <script src="{{{ asset('/theme/js/bootstrap.min.js') }}}"></script>
    
     <!-- Custom and plugin javascript -->
    <script src="{{{ asset('/theme/js/inspinia.js') }}}"></script>
    <script src="{{{ asset('/theme/js/plugins/pace/pace.min.js') }}}"></script>
    <script src="{{{ asset('/addtohomescreen/src/addtohomescreen.js') }}}"></script>

    <script>
        // addToHomescreen.removeSession();
        addToHomescreen({
            maxDisplayCount:5,
            displayPace: 20,
        });
    </script>
</html>
