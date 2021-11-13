<!doctype html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="@yield('description', 'Watch Biography Movies Online For Free and Download the latest Biography movies without Registration at 123movies org')">
    <meta content="width=device-width, initial-scale=1, user-scalable=no" name="viewport">
    <title>@yield('title', '123Torrents.io')</title>
    <link rel="icon" href="/index.ico" sizes="32x32" />
    <link rel="icon" href="/index.ico" sizes="192x192" />
    <link rel="apple-touch-icon-precomposed" href="/index.ico" />

    <!-- Google icon -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="/css/hover.css" rel="stylesheet">

    <!-- Bootstrap css -->
    <!-- build:[href] assets/css/ -->
    <link rel="stylesheet" type="text/css" href="/pmd/assets/css/bootstrap.min.css">
    <!-- /build -->

    <!-- Propeller css -->
    <!-- build:[href] assets/css/ -->
    <link rel="stylesheet" type="text/css" href="/pmd/assets/css/propeller.min.css">
    <!-- /build -->

    <!-- Propeller theme css-->
    <link rel="stylesheet" type="text/css" href="/pmd/templates/admin-dashboard/themes/css/propeller-theme.css" />

    <!-- Propeller admin theme css-->
    <link rel="stylesheet" type="text/css" href="/pmd/templates/admin-dashboard/themes/css/propeller-admin.css">

    <link rel="stylesheet" href="//cdn.rawgit.com/needim/noty/a6cccf80/lib/noty.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

    <!-- Select2 css-->
    <!-- build:[href] components/select2/css/ -->
    <link rel="stylesheet" type="text/css" href="/pmd/components/select2/css/select2.min.css" />
    <link rel="stylesheet" type="text/css" href="/pmd/components/select2/css/select2-bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="/pmd/components/select2/css/pmd-select2.css" />
    <!-- /build -->

    <!-- Custom Scrollbar css -->
    <!-- build:[href] components/custom-scrollbar/css/ -->
    <link rel="stylesheet" type="text/css" href="/pmd/components/custom-scrollbar/css/jquery.mCustomScrollbar.css" />
    <link rel="stylesheet" type="text/css" href="/pmd/components/custom-scrollbar/css/pmd-scrollbar.css" />
    <!-- /build -->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-116222873-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-116222873-1');
    </script>
    <!-- Jquery js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Bootstrap js -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="/pmd/assets/js/propeller.min.js"></script> 

    <link href="/fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="/js/tinymce/js/tinymce/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea2' });</script>
    <script src="/js/share-button/share-button.js"></script>
    <link href="/js/share-button/share-button.css" rel="stylesheet">

</head>

<body>
<!-- Header Starts -->
<!--Start Nav bar -->

<nav class="navbar pmd-navbar primary-navbar navbar-small" style="background-color: #ffffff; height: 66px; margin-bottom: 0px;">

    <div style="background-color: rgba(9, 175, 223, 0.8); width: 100%; height: 3px; display: none;" id="pjax_loading"></div>

    <div class="container">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <a href="/" class="navbar-brand">
                <img src="/ZMPFgna.png" style="max-height: 50px;">
          </a>
        </div>


        <div id="navbar-collapse-1" class="collapse navbar-collapse pmd-navbar-sidebar">

            @if(!Auth::User())

<div class="pull-right" style="max-width: 250px; padding-top: 15px;">
<div class="form-group pmd-textfield ">
                                            <div class="input-group">
                                                
                                                <input class="form-control" id="search_header_txt" value="@php echo isset($request) ? $request->input("keyword") : "" @endphp" type="text" style="display: block;width: 100%;height: 39px;padding: 6px 12px;padding-right: 12px;font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 2px;-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);box-shadow: inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;">

                                                <span class="pmd-textfield-focused"></span>
                                                
                                                <div class="input-group-addon" style="padding-left: 0px;">
                                                <a href="javascript: void(0);" class="btn" id="search_header_submit" style="display: inline; background-color: #259b24; height: 40px; position: relative; top: 0px; left: -3px; border-radius: 4px; border-top-left-radius: 0px; border-bottom-left-radius: 0px; padding-right: 12px;padding-top: 12px;">
                                                    
                                                    <i class="fa fa-search" style="color: white; font-size: 14px;"></i>
                                                </a>
                                            </div>

                                            </div>
                                        </div>
</div>
<style>
.pmd-textfield-focused {
    background-color: #259b24;
}
</style>
<script type="text/javascript">
$(document).ready(function() {

    $("#search_header_submit").click(function() {
        $("#search_header_submit").addClass("disabled").attr("disabled", true).html("<i class='fa fa-spin fa-spinner' style='color: white; font-size: 14px;'></i>");
        window.location = '/browse?keyword='+$("#search_header_txt").val();
        return false;
    });

    $("#search_header_txt").keypress(function(e) {
        if(e.which == 13) {
            $("#search_header_submit").addClass("disabled").attr("disabled", true).html("<i class='fa fa-spin fa-spinner' style='color: white; font-size: 14px;'></i>");
            window.location = '/browse?keyword='+$("#search_header_txt").val();
        }
    });

    /* Airport Search Auto-Suggest */
     var options = {
          url: function(phrase) {
            return "/api/torrents/search?keyword="+phrase;
          },

          getValue: function(element) {
            return element.name;

          },

          ajaxSettings: {
            dataType: "json",
            method: "GET",
            data: {
              dataType: "json"
            }
          },

          preparePostData: function(data) {
            data.phrase = $("#example-ajax-post").val();
            return data;
          },

          requestDelay: 400,

          cssClasses: "sheroes",

        template: {
            type: "custom",
            method: function(value, item) {
                return item.icon + " | " + value;
            }
        },

          list: {
            showAnimation: {
              type: "slide"
            },
            hideAnimation: {
              type: "slide"
            }
          }
    };
    $("#search_header").easyAutocomplete(options);
    /* End Airline Search Autosuggest */

})


</script>

<!--
                <a href="/register" class="btn pmd-btn-raised pmd-ripple-effect btn-primary pull-right">Sign Up</a>
                <a href="/login" class="btn pmd-btn-raised pmd-ripple-effect btn-success pull-right"  style="margin-left: 30px;">Login</a>
-->
            @else
                <a href="/flight/submit" class="btn pmd-btn-raised pmd-ripple-effect btn-success pull-right"  style="margin-left: 30px; display: none;"><i class="fa fa-plus"></i> Upload Torrent</a>
                <div class="dropdown pull-right" style="padding-top: 15px; margin-left: 30px; min-width: 160px;">
                  <a id="dLabel" data-target="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: white; ">
                    <img src="{{ \Auth::User()->avatar() }}" class="img-rounded my_avatar" style="height: 35px;">
                    <span>{{Auth::User()->username}}!</span>
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="dLabel" style="border-radius: 2px !important;">
                    @if(\Auth::User()->hasRole('admin'))
                        <li><a class="dropdown-item" href="/admin"><i class="fa fa-cubes"></i> Admin</a></li>
                    @endif
                    <li><a class="dropdown-item" href="/user/{{Auth::User()->name}}"><i class="fa fa-user"></i> My Profile</a></li>
                    <li><a class="dropdown-item" href="/account/settings"><i class="fa fa-cog"></i> Account Settings</a></li>
                    <li><a class="dropdown-item" href="/refer"><i class="fa fa-users"></i> Referrals</a></li>
                    <li><div class="dropdown-divider"></div></li>
                    <li><a class="dropdown-item" href="/logout"><i class="fa fa-sign-out"></i> Logout</a></li>
                  </ul>
                </div>
            @endif

                <!--nav -->
                <ul id="menu-top-menu" class="nav navbar-nav navbar-left">
                    <li class="menu-item menu-item-type-post_type menu-item-object-page @php if(Request::is('/')) echo "active";  @endphp">
                            <a rel="about" href="/"><span class="glyphicon about"></span>&nbsp;Home</a>
                    </li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page @php if(Request::is('browse') || Request::is('torrent')) echo "active";  @endphp">
                            <a rel="deals" href="/browse"><span class="glyphicon about"></span>&nbsp;Browse</a>
                    </li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page @php if(Request::is('recent')) echo "active";  @endphp">
                            <a rel="deals" href="/recent"><span class="glyphicon about"></span>&nbsp;Recent</a>
                    </li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page @php if(Request::is('top')) echo "active";  @endphp">
                            <a rel="deals" href="/top"><span class="glyphicon about"></span>&nbsp;Top</a>
                    </li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page @php if(Request::is('search/cloud')) echo "active";  @endphp">
                            <a rel="deals" href="/search/cloud"><span class="glyphicon about"></span>&nbsp;Search Cloud</a>
                    </li>

               </ul>
               <!--nav -->
        </div>
    </div>

</nav><!--End Nav bar -->
<!-- Header Ends -->

<style>
#menu-top-menu a {
    font-family: 'Montserrat', sans-serif !important;
    font-size: 14px !important;
    color: #333;
    text-transform: none !important;
    font-weight: 700;
}
#menu-top-menu a:hover { 
    background-color: transparent !important;
}
#navbar-collapse-1 > a {
    margin-top: 15px;
    margin-left: 10px;
    font-weight: 800;

}

#menu-top-menu .active { 
    border-bottom: 3px solid #79c142;
}
.pmd-navbar .navbar-nav > li > a {
    line-height: 22px !important;
}


.content-area-header {
    border-bottom: 1px solid #d1cfc5;
}
.card-content-area {
    background-color: white !important;
    border-radius: 3px;
    border: 1px solid #d1cfc5;
    border-top: 4px solid #00AEEF !important;
}
.content-area-body {
    padding: 10px;
}
.content-area-header {
    padding-top: 5px;
    padding-bottom: 5px;
    background-color: #FCFCFC !important;
}
.content-area-header a {
    padding: 10px;
    font-weight: 800;
}
.content-area-header h3 {
    padding: 10px;
    margin-top: 0px; 
    margin-bottom: 0px;
}
.dropdown-menu li a {
    padding-top: 9px !important;
    padding-bottom0: 9px !important;
}
</style>


    <!--content area start-->
    <div id="content" class="pmd-content inner-page"  style="margin-left: 0px; padding-top: 0px; ">
        @yield("content")
    </div><!-- content area end -->

<!-- Footer Starts -->
<footer id="footer" class="admin-footer" style="background-color: #3d3d3d; color: white; ">
 <div class="container">

    <div class="pull-right">
        <ul class="list-unstyled list-inline">
            <li>
                <a href="/privacy" style="color: white;">Privacy Policy</a> &middot; <a href="/dmca" style="color: white;">DMCA</a> &middot; <a href="/rss" style="color: white;">RSS Feed</a> &middot; 
                <a href="/contact" style="color: white;">Contact Us</a> 
            </li>
        </ul>
    </div>

    <div class="pull-left">
        <ul class="list-unstyled list-inline">
            <li>
                <span class="pmd-card-subtitle-text">123Torrents.io v0.1b <span style="display: inline-block;transform: rotate(180deg);">&copy;</span> <span class="auto-update-year">2018</span>. No Rights Reserved.</span>
                <h3 class="pmd-card-subtitle-text" style="color: grey;">Created with <i class="fa fa-heart" style="color: red;"></i> by Gerbils in {{ number_format((microtime(true) - LARAVEL_START), 3) }} seconds.</h3>
            </li>
        </ul>
    </div>
 </div>
</footer>

<style>
#content {
  margin: 0 auto;
  padding-top: 64px;
}

html {
  height: 100%;
  box-sizing: border-box;
}

*,
*:before,
*:after {
  box-sizing: inherit;
}

body {
  position: relative;
  margin: 0;
  min-height: 100%;
}

#footer {
    width: 100%;
}



</style>
<!-- Footer Ends -->
<script type="text/javascript">
  var footerResize = function() {
    console.log("ih");
    if(($("#content").height()) < $(window).height()) {
        $('#footer').css('position', 'absolute');
        $('#footer').css('bottom', '0px');
        $('#content').css('padding-bottom', '0px');
        $('#content').css('margin-bottom', '0px');
        $('#content').css('min-height', '0px');
        $('body').css('min-height', '0px');
    } else {

    }

    //$('#footer').css('position', $("body").height() + $("#footer").innerHeight() > $(window).height() ? "inherit" : "fixed");
  };
  $(window).resize(footerResize).ready(footerResize);
</script>



<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="//cdn.rawgit.com/needim/noty/a6cccf80/lib/noty.min.js"></script>
<script src="//cdn.jsdelivr.net/mojs/latest/mo.min.js"></script>
<script src="//cdn.jsdelivr.net/velocity/1.5/velocity.min.js"></script>
<script src="/js/bounce.js"></script>
<!-- Scripts Ends -->


<script type="text/javascript" src="/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js"></script>
<link href="/EasyAutocomplete-1.3.5/easy-autocomplete.css" rel="stylesheet">
<!-- Select2 js-->
<!-- build:[src] components/select2/js/ -->
<script type="text/javascript" src="/pmd/components/select2/js/select2.full.js"></script>
<!-- /build -->


<!-- build:[src] components/select2/js/ -->
<script type="text/javascript" src="/pmd/components/select2/js/pmd-select2.js"></script>
<!-- /build -->


 

<!-- Scripts Ends -->
<!-- custom scrollbar plugin -->
<!-- build:[src] components/custom-scrollbar/js/ -->
<script type="text/javascript" language="javascript" src="/pmd/components/custom-scrollbar/js/jquery.mCustomScrollbar.js"></script>
<!-- /build -->



<script type="text/javascript">

function notyError(msg) {
    new Noty({
        text: msg,
        type: "error",
        timeout: 5000,
        animation: {
            open: function (promise) {
                var n = this;
                var Timeline = new mojs.Timeline();
                var body = new mojs.Html({
                    el        : n.barDom,
                    x         : {500: 0, delay: 0, duration: 500, easing: 'elastic.out'},
                    isForce3d : true,
                    onComplete: function () {
                        promise(function(resolve) {
                            resolve();
                        })
                    }
                });

                var parent = new mojs.Shape({
                    parent: n.barDom,
                    width      : 200,
                    height     : n.barDom.getBoundingClientRect().height,
                    radius     : 0,
                    x          : {[150]: -150},
                    duration   : 1.2 * 500,
                    isShowStart: true
                });

                n.barDom.style['overflow'] = 'visible';
                parent.el.style['overflow'] = 'hidden';

                var burst = new mojs.Burst({
                    parent  : parent.el,
                    count   : 10,
                    top     : n.barDom.getBoundingClientRect().height + 75,
                    degree  : 90,
                    radius  : 75,
                    angle   : {[-90]: 40},
                    children: {
                        fill     : '#EBD761',
                        delay    : 'stagger(500, -50)',
                        radius   : 'rand(8, 25)',
                        direction: -1,
                        isSwirl  : true
                    }
                });

                var fadeBurst = new mojs.Burst({
                    parent  : parent.el,
                    count   : 2,
                    degree  : 0,
                    angle   : 75,
                    radius  : {0: 100},
                    top     : '90%',
                    children: {
                        fill     : '#EBD761',
                        pathScale: [.65, 1],
                        radius   : 'rand(12, 15)',
                        direction: [-1, 1],
                        delay    : .8 * 500,
                        isSwirl  : true
                    }
                });

                Timeline.add(body, burst, fadeBurst, parent);
                Timeline.play();
            },
            close: function (promise) {
                var n = this;
                new mojs.Html({
                    el        : n.barDom,
                    x         : {0: 500, delay: 10, duration: 500, easing: 'cubic.out'},
                    skewY     : {0: 10, delay: 10, duration: 500, easing: 'cubic.out'},
                    isForce3d : true,
                    onComplete: function () {
                        promise(function(resolve) {
                            resolve();
                        })
                    }
                }).play();
            }
        }
    }).show();
}

new Noty({
    text: 'Welcome to 123Torrents. Please report any bug or issues.',
    type: "info",
    animation: {
        open: function (promise) {
            var n = this;
            var Timeline = new mojs.Timeline();
            var body = new mojs.Html({
                el        : n.barDom,
                x         : {500: 0, delay: 0, duration: 500, easing: 'elastic.out'},
                isForce3d : true,
                onComplete: function () {
                    promise(function(resolve) {
                        resolve();
                    })
                }
            });

            var parent = new mojs.Shape({
                parent: n.barDom,
                width      : 200,
                height     : n.barDom.getBoundingClientRect().height,
                radius     : 0,
                x          : {[150]: -150},
                duration   : 1.2 * 500,
                isShowStart: true
            });

            n.barDom.style['overflow'] = 'visible';
            parent.el.style['overflow'] = 'hidden';

            var burst = new mojs.Burst({
                parent  : parent.el,
                count   : 10,
                top     : n.barDom.getBoundingClientRect().height + 75,
                degree  : 90,
                radius  : 75,
                angle   : {[-90]: 40},
                children: {
                    fill     : '#EBD761',
                    delay    : 'stagger(500, -50)',
                    radius   : 'rand(8, 25)',
                    direction: -1,
                    isSwirl  : true
                }
            });

            var fadeBurst = new mojs.Burst({
                parent  : parent.el,
                count   : 2,
                degree  : 0,
                angle   : 75,
                radius  : {0: 100},
                top     : '90%',
                children: {
                    fill     : '#EBD761',
                    pathScale: [.65, 1],
                    radius   : 'rand(12, 15)',
                    direction: [-1, 1],
                    delay    : .8 * 500,
                    isSwirl  : true
                }
            });

            Timeline.add(body, burst, fadeBurst, parent);
            Timeline.play();
        },
        close: function (promise) {
            var n = this;
            new mojs.Html({
                el        : n.barDom,
                x         : {0: 500, delay: 10, duration: 500, easing: 'cubic.out'},
                skewY     : {0: 10, delay: 10, duration: 500, easing: 'cubic.out'},
                isForce3d : true,
                onComplete: function () {
                    promise(function(resolve) {
                        resolve();
                    })
                }
            }).play();
        }
    }
}).show();
</script>


<!-- Tooltip Js -->
<script>
    $(document).ready(function(){
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    });
</script>

</body>
</html>