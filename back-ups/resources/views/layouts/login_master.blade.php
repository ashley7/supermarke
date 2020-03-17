<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured Point Of sale records system for All businesses.">
        <meta name="author" content="Thembo Charles Lwanga">

        <!-- App Favicon -->

        <link rel="icon" href="{{asset('images/logo.png')}}">

        <!-- App title -->
         <title>{{ config('app.name', '') }}</title>

        <!-- App CSS -->
        <link href="{{asset('back_end/assets/css/style.css')}}" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script src="{{asset('back_end/assets/js/modernizr.min.js')}}"></script>
    </head>
    <body>

        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">

               <!-- ============================================================== -->
               <!--  Blade template -->
                <!-- ============================================================== -->
                        @yield('content')
                <!-- ============================================================== -->
                <!-- End Blade template -->
                <!-- ============================================================== -->          

        </div>
        <!-- end wrapper page -->


        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <!-- jQuery  -->
        <script src="{{asset('back_end/assets/js/jquery.min.js')}}"></script>

        <script>

              $("#refresh").hide();

              $("#login_btn").click(function() {
                $("#login_btn").text("loging in ...");          
                $("#login_btn").attr("disabled","disabled");
                $("#refresh").show();
            });
        </script>

        <!-- App js -->



    </body>
</html>