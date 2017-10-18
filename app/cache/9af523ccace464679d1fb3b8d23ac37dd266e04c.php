<?php $__env->startSection('content'); ?>

<div class="container">
  <div class="row">
  <div class="card">
    <div class="card-image waves-effect waves-block waves-light">
      <img class="activator" src="<?php echo e($data->image); ?>">
    </div>
    <div class="card-content">
      <span class="card-title activator grey-text text-darken-4"><?php echo e($data->title); ?></span>
      <p><?php echo $data->content; ?></p>
    </div>
  </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.user.templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>