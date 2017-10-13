<!-- Alert Material -->
<?php if(isset($messages['success'])): ?>
    <div class="card-panel green lighten-4 green-text text-alert-4"><b>Success! </b>      
      <strong>
        <?php $__currentLoopData = $messages['success']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php echo e($m); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </strong>
    <span class="pull-right"><i class="material-icons prefix">close</i></span>
    </div>      
<?php endif; ?>

<?php if(isset($messages['error'])): ?>
    <div class="card-panel red lighten-4 red-text text-alert-4"><b>Error! </b>       
    <strong>
        <?php $__currentLoopData = $messages['error']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php echo e($m); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </strong>
    <span class="pull-right"><i class="material-icons prefix">close</i></span>
    </div>      
<?php endif; ?>

<?php if(isset($messages['warning'])): ?>
    <div class="card-panel yellow lighten-4 yellow-text text-alert-4"><b>Warning! </b>
        <strong>
        <?php $__currentLoopData = $messages['warning']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php echo e($m); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </strong>
    <span class="pull-right"><i class="material-icons prefix">close</i></span>
    </div>      
<?php endif; ?>

<?php if(isset($messages['info'])): ?>
    <div class="card-panel blue lighten-4 blue-text text-alert-4"><b>Info! </b>
        <strong>
        <?php $__currentLoopData = $messages['info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php echo e($m); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </strong>
    <span class="pull-right"><i class="material-icons prefix">close</i></span>
    </div>
<?php endif; ?>

<script>
    window.setTimeout(function() {
    $(".alert-dismissible").fadeTo(700, 0).slideUp(700, function(){
        $(this).remove();
    });
}, 3700);
window.setTimeout(function() {
    $(".text-alert-4").fadeTo(700, 0).slideUp(700, function(){
        $(this).remove();
    });
}, 3700);
</script>