<!DOCTYPE html>
<html>
  <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dark Bootstrap Admin </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{asset('front-end/myAdminStyle/style.css')}}">
    {{-- Animate.css CDN link --}}
    <link rel="stylesheetx" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('admin/vendor/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{asset("admin/vendor/font-awesome/css/font-awesome.min.css")}}">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="{{asset("admin/css/font.css")}}">
    {{-- link icon bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="{{asset("https://fonts.googleapis.com/css?family=Muli:300,400,700")}}">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{asset("admin/css/style.default.css")}}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{asset("admin/css/custom.css")}}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{asset("admin/admin/img/favicon.ico")}}">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <style>
    #success-alert {
        transition: opacity 3s ease;
        opacity: 1;
    }
    #success-alert.hide {
        opacity: 0;
    }
</style>
  <body>
    <header class="header">   
      <nav class="navbar navbar-expand-lg">
        <div class="container-fluid d-flex align-items-center justify-content-between">
          <div class="navbar-header">
            <!-- Navbar Header--><a href="index.html" class="navbar-brand">
              <div class="brand-text brand-big visible text-uppercase"><strong class="text-primary">HENGHOR</strong><strong>Admin</strong></div>
              <div class="brand-text brand-sm"><strong class="text-primary">H</strong><strong>H</strong></div></a>
            <!-- Sidebar Toggle Btn-->
            <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
          </div>
          <div class="right-menu list-inline no-margin-bottom">                      
            <div class="list-inline-item logout">
              <a href="{{route('index')}}">Shop</a>
            </div>
            <!-- Log out -->
            <div class="list-inline-item logout">
                 <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
          </div>
        </div>
      </nav>
    </header>
    <div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
      <nav id="sidebar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar"><img src="" alt="..." class="img-fluid rounded-circle"></div>
          <div class="title">
            <h1 class="h5">Admin</h1>
            <p>E-Commerce</p>
          </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
        <ul class="list-unstyled">
        <li class="active"><a href=""> <i class="icon-home"></i>Home </a></li>
         <li><a href="#exampledropdownDropdownCategory" aria-expanded="false" data-toggle="collapse"> <i class="icon-windows"></i>Category </a>
            <ul id="exampledropdownDropdownCategory" class="collapse list-unstyled ">
            <li><a href="{{route('admin.addcategory')}}">Add Category</a></li>
            <li><a href="{{route('admin.viewcategory')}}">View Category</a></li>
        </ul>
        </li>
        <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-windows"></i>Product </a>
            <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
            <li><a href="{{route('admin.add_product')}}">Add Product</a></li>
            <li><a href="{{route('admin.view_product')}}">View Product</a></li>
            <li><a href="{{route('admin.view_order')}}">View Order</a></li>
        </ul>
        </li>
      </nav>
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Dashboard</h2>
          </div>
        </div>
        <section class="no-padding-top no-padding-bottom">
         @yield('dashboard')

         @yield('add_category')

         @yield('viewcategory')

         @yield('editcategory')

         @yield('addProduct')

         @yield('viewproduct')

        @yield('vieworder')

        @yield('editproduct')
        </section>
        {{-- End of section --}}
        <footer class="footer">
          <div class="footer__block block no-margin-bottom">
            <div class="container-fluid text-center">
              <span>HENGHOR CAR ACCESSORIES</span>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{asset("admin/vendor/jquery/jquery.min.js")}}"></script>
    <script src="{{asset("admin/vendor/popper.js/umd/popper.min.js")}}"> </script>
    <script src="{{asset("admin/vendor/bootstrap/js/bootstrap.min.js")}}"></script>
    <script src="{{asset("admin/vendor/jquery.cookie/jquery.cookie.js")}}"> </script>
    <script src="{{asset("admin/vendor/chart.js/Chart.min.js")}}"></script>
    <script src="{{asset("admin/vendor/jquery-validation/jquery.validate.min.js")}}"></script>
    <script src="{{asset("admin/js/charts-home.js")}}"></script>
    <script src="{{asset("admin/js/front.js")}}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('admin/vendor/Alert/alert.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
    <!--custom JS -->
    <script src="{{asset('')}}"></script>
  </body>
</html>