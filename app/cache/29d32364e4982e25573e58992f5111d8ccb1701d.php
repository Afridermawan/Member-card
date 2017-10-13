<?php $__env->startSection('content'); ?>

<div class="container">
  <div class="row">
    <?php $__currentLoopData = $data->data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $datas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col s12 m6 hoverable">
      <div class="card">
        <div class="card-image waves-effect waves-block waves-light">
          <img class="activator" src="<?php echo e($datas->thumbnail); ?>" style="width: 350px;min-height: 300px;max-height: 300px">
        </div>
        <div class="card-content">
          <a href="<?php echo e($base_url); ?>/web/article/<?php echo e($datas->id); ?>/detail">
            <span class="card-title activator grey-text text-darken-4"><?php echo e($datas->title); ?></span>
          </a>
            <p><?php echo substr($datas->content,0, 300); ?> 
                <a href="<?php echo e($base_url); ?>/web/article/<?php echo e($datas->id); ?>/detail">Readmore...</a>
            </p>
        </div>
      </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
</div>
  <?php if(isset($data->meta->pagination)): ?>
      <?php
      $page = $data->meta->pagination;
      ?>
      <ul class="pagination center">
          <?php if(isset($page->links->previous)): ?>
          <li><a href="<?php echo e($link); ?>?page=1">First</a></li>
          <li><a href="<?php echo e($link); ?>?page=<?php echo e($page->current_page-1); ?>"><<</a></li>
          <?php else: ?>
          <li class="disabled"><a class="disabled">First</a></li>
          <li class="disabled"><a class="disabled"><<</a></li>
          <?php endif; ?>

      <?php $x = $page->total_pages+1; ?>

      <?php for($i =1; $i<$x; $i++ ): ?>
          <?php if($page->current_page==$i): ?>
          <li class="active"><a href=""><?php echo e($i); ?></a></li>
          <?php else: ?>
          <li><a href="<?php echo e($link); ?>?page=<?php echo e($i); ?>"><?php echo e($i); ?></a></li>
          <?php endif; ?>
      <?php endfor; ?>

          <?php if(isset($page->links->next)): ?>
          <li><a href="<?php echo e($link); ?>?page=<?php echo e($page->current_pages+1); ?>">>></a></li>
          <li><a href="<?php echo e($link); ?>?page=<?php echo e($page->total_pages); ?>">Last</a></li>
          <?php else: ?>
          <li class="disabled"><a>>></a></li>
          <li class="disabled"><a class="disabled">Last</a></li>
          <?php endif; ?>
      </ul>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.user.templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>