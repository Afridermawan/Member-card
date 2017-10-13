<?php if(isset($messages['success'])): ?>
    <div class="alert alert-success alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <strong>
      	<?php $__currentLoopData = $messages['success']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      		<?php echo e($m); ?>

      	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </strong>
    </div>
<?php endif; ?>
<?php if(isset($messages['info'])): ?>
    <div class="alert alert-info alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <strong>
      	<?php $__currentLoopData = $messages['info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      		<?php echo e($m); ?>

      	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </strong>
    </div>
<?php endif; ?>
<?php if(isset($messages['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <strong>
      	<?php $__currentLoopData = $messages['error']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      		<?php echo e($m); ?>

      	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </strong>
    </div>
<?php endif; ?>