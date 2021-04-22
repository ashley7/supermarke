<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured transport system.">
        <meta name="author" content="Thembo Charles Lwanga ()">
        <meta name="author_email" content="ashley7520charles@gmail.com">

         <link rel="icon" href="{{asset('images/logo.png')}}">

         <title>{{$title}}</title>

        <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/buttons.dataTables.min.css') }}">
        <link href="{{asset('back_end/assets/css/style.css')}}" rel="stylesheet" type="text/css" />
         <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <style type="text/css">
            #topnav .topbar-main {
                background-color: #035f48;
            }
            a{
                text-transform: uppercase;
            }
          
        </style>
        @yield('styles')
    </head>
    <body>

        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container">

                    <!-- LOGO -->
                    <div class="topbar-left">
                        <a href="/home" class="logo">
                            <!-- <i class="zmdi zmdi-case icon-c-logo"></i> -->
                            <img src="{{asset('images/logo.png')}}" width="5%">
                            <span>{{ config('app.name', '') }}</span>                     
                        </a>
                    </div>
                    <!-- End Logo container-->
                        <div class="menu-extras">

                        <ul class="nav navbar-nav pull-right">
                            <li class="nav-item">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle">
                                    <div class="lines">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>  


                  
                        
                            <li class="nav-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                    <!-- <img src="back_end/assets/images/users/avatar-1.jpg" alt="{{Auth::user()->name}}" class="img-circle"> -->
                                    <span style="color: #FFF;">{{Auth::user()->name}}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-arrow profile-dropdown " aria-labelledby="Preview">                                
                                  

                                 

                                   
                                    <!-- item-->                                 
                                      
                                    <a href="{{ route('logout') }}" class="dropdown-item notify-item"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                       <i class="zmdi zmdi-power"> Logout</i>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>                             
                                     

                                </div>
                            </li>

                        </ul>

                    </div> <!-- end menu-extras -->
                    <div class="clearfix"></div>

                </div> <!-- end container -->
            </div>
            <!-- end topbar-main -->

            <div class="navbar-custom">
                <div class="container">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">                           

                            <li class="has-submenu">
                                <a href="{{route('sales.create')}}"><i class="zmdi zmdi-view-dashboard"></i>  Dashboard</a>
                            </li>
                             
                            <li class="has-submenu">
                                <a href="{{route('main_sale.create')}}"><i class="zmdi zmdi-shopping-cart"></i>  Record sales</a>
                            </li>

                            <li class="has-submenu">
                                <a href="#"><i class="zmdi zmdi-account"></i>Customer</a>
                                <ul class="submenu">
                                   <li> <a href="{{route('customer.index')}}">Customer</a></li>
                                   <li> <a href="{{route('customer_request.index')}}">Customer Requests</a></li>
                                                                   
                                </ul>
                            </li> 

                         

                            <li class="has-submenu">
                                <a href="{{route('bank_deposite.index')}}"><i class="zmdi zmdi-store-24"></i> Bank Transaction</a>
                            </li>

                            <li class="has-submenu">
                                <a href="{{route('expense.index')}}"><i class="zmdi zmdi-mall"></i>  Expenses</a>
                            </li>

                            <li class="has-submenu">
                                <a href="{{route('purchase_payment.index')}}"><i class="zmdi zmdi-shopping-basket"></i>  Purchases</a>
                            </li>                         
                                           

                            <li class="has-submenu">
                                <a href="#"><i class="zmdi zmdi-settings"></i>Tools</a>
                                <ul class="submenu">
                                   <li> <a href="{{route('stock.index')}}">Stock</a></li>
                                   <li> <a href="{{route('adhoc_report.create')}}">Period sales</a></li>
                                   <li> <a href="{{route('stock_sales.create')}}">Period stock sales</a></li>
                                    <!-- <li> <a href="{{route('stock.create')}}">Create</a></li> -->
                                   <!-- <li> <a href="{{route('supplier.create')}}">Add Supplier</a></li> -->
                                   <!-- <li> <a href="{{route('stock.create')}}">Add Stock names</a></li> -->
                                   <!-- <li> <a href="{{route('price_tag.create')}}">Add Price tags</a>  </li>           -->
                                   <!-- <li> <a href="{{route('account.create')}}">Add Expense account</a></li> -->
                                   <!-- <li> <a href="{{route('bank.create')}}">Add Bank</a></li> -->
                                   <!-- <li> <a href="{{route('user.index')}}">Add new Users</a></li>                                 -->
                                </ul>
                            </li>  

                                                   
                        </ul>
                    </div>  
                </div>  
            </div>  
        </header>
     
 
        <div class="wrapper">
            <div class="container">
                @yield('content')    
                <footer class="footer text-right">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                              © <?php echo date("Y") ?> Agrosupply (U) ltd. All rights reserved
                            </div>
                        </div>
                    </div>
                </footer>         
            </div>  
        </div>  

        <script>
            var resizefunc = [];
        </script>

        <script src="{{ asset('js/jquery-1.12.4.js') }}"></script>
        <!-- <script src="{{asset('back_end/assets/js/tether.min.js')}}"></script> -->
        <script src="{{asset('back_end/assets/js/bootstrap.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/choosen.js')}}"></script>

        <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
        <script src="{{ asset('js/jszip.min.js') }}"></script>
        <script src="{{ asset('js/pdfmake.min.js') }}"></script>
        <!-- <script src="{{ asset('js/vfs_fonts.js') }}"></script> -->
        <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
<!--         <script src="{{ asset('js/buttons.print.min.js') }}"></script>
 -->
        <script type="text/javascript">

             $(document).ready(function() {
                $('#example,#sales_table,#stock_table,#loss,#expenses_table').DataTable( {
                    dom: 'Bfrtip',
                    ordering: false,
                    aaSorting: [],
                    pageLength: 500,
                    buttons: [
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ]
                } );
            } );      
        
        </script>
   
     

      <script type="text/javascript">
        var el = document.querySelector('input.number');
        el.addEventListener('keyup', function (event) {
          if (event.which >= 37 && event.which <= 40) return;
          this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        });
     </script>

        <script type="text/javascript">
        var el = document.querySelector('input.next_number');
        el.addEventListener('keyup', function (event) {
          if (event.which >= 37 && event.which <= 40) return;
          this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        });
     </script>

      <script>
        function myFunction() {
            window.print();
        }
    </script>
     @stack('scripts')
    </body>
</html>