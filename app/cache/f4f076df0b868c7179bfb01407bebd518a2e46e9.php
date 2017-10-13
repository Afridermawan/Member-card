<?php $__env->startSection('content'); ?>

<div class="container">
  <div class="row">
    <div class="card">
      <div class="card-image waves-effect waves-block waves-light">
        <img class="activator" src="<?php echo e($data->thumbnail); ?>" style="max-height: 400px;min-height: 400px">
      </div>
      <div class="card-content">
        <span class="card-title activator grey-text text-darken-4"><?php echo e($data->title); ?></span>
            <?php $__currentLoopData = $data->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="chip">
            <?php echo e($tag->tag); ?>

          </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <p><?php echo $data->content; ?> 
          </p>
      </div>
    </div>
  </div>
</div>
    <?php $__currentLoopData = $comment->data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="container">
  <div class="card"  style="border-radius: 25px">
    <div class="chip" style="margin: 15px">
      <img src="<?php echo e($comments->image); ?>" alt="Contact Person">
      <?php echo e($comments->username); ?>

      <p style="padding-left: 20px"><i class="material-icons prefix">subdirectory_arrow_right</i> <?php echo e($comments->comment); ?></p>
    </div>
  </div>
</div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<div class="container"> 
    <div class="row">
      <div class="input-field col s12">
      <form action="<?php echo e($base_url); ?>/web/article/<?php echo e($data->id); ?>/comment" method="post">
        <textarea name="comment" id="textarea1" class="materialize-textarea"></textarea>
        <button class="btn btn-default"><i class="fa fa-reply"></i> Submit</button>
        <label for="textarea1">Comment :</label>
      </form>
      </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.user.templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>