

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="_token" content="{!! csrf_token() !!}"/>
 <!--  @yield('title') -->
 <title>Fisher Classic</title>

  <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
  <link href="{{{ asset('/css/main.css') }}}" rel="stylesheet">
  <link href="{{{ asset('/theme/css/bootstrap.css') }}}" rel="stylesheet">
  <link href="{{{ asset('/theme/font-awesome/css/font-awesome.css') }}}" rel="stylesheet">
  <link href="{{{ asset('/theme/css/animate.css') }}}" rel="stylesheet">
  <link href="{{{ asset('/theme/css/style.css') }}}" rel="stylesheet">
  <link href="{{{ asset('/theme/css/plugins/sweetalert/sweetalert.css') }}}" rel="stylesheet">
  <link href="{{{ asset('/fonts/blacksword/stylesheet.css') }}}" rel="stylesheet">
  <link href="{{{ asset('/addtohomescreen/style/addtohomescreen.css') }}}" rel="stylesheet" type="text/css" >


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
  <script src="{{{ asset('/addtohomescreen/src/addtohomescreen.js') }}}"></script>
  

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
  <!-- ******** SIDE NAV ******** -->
  <div style="position:fixed;">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element" style="text-align: center;"> 
                      <span class="team-score">
                        <h1>-</h1>
                      </span>
                      <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->name }}</strong></span></span> 
                    </div>
                  <div class="logo-element">
                      <span class="team-score">
                        <h1>-</h1>
                      </span>
                  </div>
                </li>
                <li id="menu-course">
                    <a href="course"><i class="fa fa-flag"></i> <span class="nav-label">Course</span></a>
                </li>
                <li id="menu-standings">
                    <a href="standings"><i class="fa fa-trophy"></i> <span class="nav-label">Standings</span></a>
                </li>
                <li id="menu-map">
                    <a href="map"><i class="fa fa-globe"></i> <span class="nav-label">Map</span></a>
                </li>
                <li id="menu-stats">
                    <a href="analytics"><i class="fa fa-bar-chart"></i> <span class="nav-label">Stats</span></a>
                </li>
                <li id="menu-logout">
                    <a href="logout"><i class="fa fa-sign-out"></i> <span class="nav-label">Log Out</span></a>
                </li>
                 @if(Auth::user()->getId() == 1)
                    <li id="menu-admin">
                        <a href="admin"><i class="fa fa-gears green-text"></i> <span class="nav-label">Admin</span></a>
                    </li>
                @endif
<!--                 <li id="menu-settings">
                    <a href="#"><i class="fa fa-gears"></i> <span class="nav-label">Settings</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                         <li><a href="#"><i class="fa fa-user"></i>Team</a></li>
                         <li><a href="logout"><i class="fa fa-sign-out"></i>Log Out</a></li>
                    </ul>
                </li> -->
            </ul>
        </div>
    </nav>
  </div>
  <!-- ******** TOP NAV ******** -->
    <div id="page-wrapper" class="gray-bg">
      <div class="row border-bottom" style="position:fixed; z-index:999; width:100%;">
        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-green nav-btn" href="#"><i class="fa fa-chevron-right menu-button"></i> </a>
        </div>
            <ul class="nav navbar-top-links navbar-right" style="display: inline-block;">
<!--                 <li>
                    <span class="m-r-sm text-muted welcome-message">Welcome to the Fisher Classic</span>
                </li> -->
                <li class="dropdown notify-icon" >
                    <a onclick="openNotifications();" class="dropdown-toggle count-info">
                        <i class="fa fa-bell"></i>  <span id="notify-count" class="label label-primary"></span>
                    </a>

<!--                     <ul class="dropdown-menu" style="width:90vw; border:1px solid red; position:absolute; left:0;">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-trophy fa-fw"></i> Welcome to the tournament!
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                    </ul> -->
                </li>

            </ul>
            <h3 class="m-r-sm fc-font fc-header animated flipInY" style="display:inline-block; float:right;">Fisher Classic</h3>
        </nav>
      </div>
      
      <br/>
      <br/>       
      @yield('content')
      <br/>
      <br/>

    <div id="notify-modal" class="modal fade" role="dialog" aria-hidden="true" style="z-index:99999;">
      <div class="modal-dialog">
        <div class="modal-content">     
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Notifications</h4>
            </div>     
            <div class="modal-body dropdown-alerts">
                <div class="text-center link-block">
                    <a href="notifications.html">
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </div>
      </div>
    </div>


      <!-- ****** FOOTER ******** -->
      <div class="footer">
        <div class="pull-right">
            <strong>{{ Auth::user()->name }}</strong>
        </div>
        <div>
            Fisher Classic &copy; 2016
        </div>
      </div>
    
    </div>
    <!-- end of page wrapper -->
  </div>
<!-- end of wrapper -->

    <?php $page = Request::segment(1); ?>
    <?php $userID = Auth::user()->id; ?>
    <?php $userAvatar = Auth::user()->avatar; ?>
     
<script>


        var menuState = false;
        $('.nav-btn').click(function(){ 
        menuState = !menuState;
        if(menuState){
            $('.menu-button').removeClass("fa-chevron-right");
            $('.menu-button').addClass("fa-chevron-left");
            getScore();
        } else {
            $('.menu-button').removeClass("fa-chevron-left");
            $('.menu-button').addClass("fa-chevron-right");
        }
        setTimeout(function() {
            $('.team-score h1').toggleClass("animated tada", function(){
            $(this).remove();
            });
        },1000);
        });      

        $(document).ready(function(){

            var page = '<?php echo $page ?>';
            switch(page) {
                case "course": $("#menu-course").addClass("active");
                    break;
                case "standings": $("#menu-standings").addClass("active");
                    break;
                case "map": $("#menu-map").addClass("active");
                    break;
                case "stats": $("#menu-stats").addClass("active");
                    break;
                case "settings": $("#menu-settings").addClass("active");
                    break;
            }

            $.ajaxSetup({
               headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });

            getScore();

            var count = localStorage.notifycount;
            $("#notify-count").html(count);
        })

        function getScore(){
          $.ajax({
              url: 'getScore',
              type: "GET",
              success: function(data){
              	if(data > 0){
                	$(".team-score h1").html("+" + data);
            	} else if(data < 0) {
            		$(".team-score h1").html(data);
            	} else {
            		$(".team-score h1").html("E");
            	}
              },
              error: function(error){
                console.log(error);
              }
          });      
        }

        function openNotifications(){
          $(".dropdown-alerts").empty();
          for(var i=0, len=localStorage.length; i<len; i++) {
            var key = localStorage.key(i);
            var value = localStorage[key];
            if(key != "notifycount"){
              notifyData = value.split('|');
              var alert = '<div>' + notifyData[0] + '<span class="pull-right text-muted small slate-text" style="padding-top:2px;">' + moment(notifyData[1]).fromNow() + '</span></div><hr/>';
              $(".dropdown-alerts").append(alert);
            }
          }
         $("#notify-modal").modal("show");
        }

        $('#notify-modal').on('hidden.bs.modal', function () {
            localStorage.clear();
            $("#notify-count").empty();
        })

     </script>

</body>



</html>
