<!DOCTYPE html>
<html lang="en">

<?php echo $__env->make('templates.partials.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldContent('custom_css'); ?>

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
          <?php echo $__env->make('templates.partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
      </div>

     <?php echo $__env->make('templates.partials.top-nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


      <!-- page content -->
      <div class="right_col" role="main">

          <div class="">
              <?php echo $__env->make('templates.partials.alerts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              <?php echo $__env->yieldContent('content'); ?>
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

  <?php echo $__env->make('templates.partials.script', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->yieldContent('custom_script'); ?>

   <!-- /datepicker -->
  <!-- /footer content -->
</body>

</html>
