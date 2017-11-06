<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php echo $__env->make('backend.user.templates.partials.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
     <?php echo $__env->yieldContent('custom_css'); ?>

 </head>

  <body style="background: #fafafa">

        <?php echo $__env->make('backend.user.templates.partials.navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="container">
        <div class="row justify-content-center" style="margin-top: 50px; margin-bottom: 50px;height: auto;">
            <div class="col-lg-8">
    			<?php echo $__env->make('backend.user.templates.partials.alerts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="container-fluid">
    				<?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('backend.user.templates.partials.script', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
     <?php echo $__env->yieldContent('custom_script'); ?>

  </body>
    <?php echo $__env->make('backend.user.templates.partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</html>
