<!DOCTYPE html>
<html lang="en">

@include('templates.partials.header')
@yield('custom_css')

<body class="nav-md">

  <div class="container body">

    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

          <div class="navbar nav_title" style="border: 0;">
            <a href="  " class="site_title"> <span>Member Card</span></a>
          </div>
          <div class="clearfix"></div>

          <!-- sidebar menu -->
          @include('templates.partials.sidebar') 
        </div>
      </div>

     @include('templates.partials.top-nav')


      <!-- page content -->
      <div class="right_col" role="main">

          <div class="">
              @include('templates.partials.alerts')
              @yield('content')
          </div>
        <!-- footer content -->

        <footer>
        <!-- <a href="https://colorlib.com">Colorlib</a> -->
          <div class="copyright-info">
            <p class="pull-right"><strong>Copyright &copy; 2017 <a href="#">Member-Card</a>.</strong> All rights reserved.
            </p>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
      <!-- /page content -->

    </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>

  @include('templates.partials.script')
  @yield('custom_script')

   <!-- /datepicker -->
  <!-- /footer content -->
</body>

</html>
