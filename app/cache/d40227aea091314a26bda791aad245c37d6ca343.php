<?php $__env->startSection('content'); ?>

<div class="container">
  <?php echo $__env->make('backend.user.templates.partials.alerts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <div class="row">
    <form class="col s12 center" action="<?php echo e($base_url); ?>/web/pin/edit" method="post">
        <div class="input-field col s12">
          <input value="<?php echo e($data->pin); ?>" name="pin" id="pin" type="text" class="validate">
          <label for="pin">PIN</label>
        </div>
      <div class="card-action center-align">
        <button class="btn waves-effect waves-light" type="submit" name="action">Edit
        </button>
      </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.user.templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>