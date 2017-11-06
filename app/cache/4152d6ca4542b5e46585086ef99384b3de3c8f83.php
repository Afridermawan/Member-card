<?php $__env->startSection('content'); ?>

<div class="container">
  <div class="row">
    <nav style="border-radius: 25px;margin-top: 20px">
      <div class="nav-wrapper">
        <div class="col s12">
            <span style="font-family:  Tibetan Machine Uni, sans-serif;font-size: 25px;">Member-Card  &nbsp</span>
            <span style="font-family:  Trebuchet, sans-serif;font-size: 20px;"> <?php echo e($title); ?></span>
            <?php if(!$session->hak_akses): ?>
                <span class="pull-right">
                    <a href="<?php echo e($base_url); ?>/web/request/send"><i class="material-icons">mode_edit</i></a>
                </span>
            <?php else: ?>
                <span class="pull-right">
                    <a href="<?php echo e($base_url); ?>/web/produk/user/add"><i class="material-icons">mode_edit</i></a>
                </span>
            <?php endif; ?>
        </div>
      </div>
    </nav>
    <br>
  </div>
</div>

<div class="container">
  <div class="row">
  <?php $__currentLoopData = $data->data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $datas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="card col s6 hoverable">
        <div class="card-image waves-effect waves-block waves-light">
          <img class="activator" src="<?php echo e($datas->image); ?>" style="width: 350px;height: 300px">
        </div>
        <div class="card-content" style="max-height: 150px; min-height: 150px;">
          <span class="card-title activator grey-text text-darken-4"><?php echo e($datas->name); ?><i class="material-icons right">more_vert</i></span>
          <div class="text-align pull-right">
            Rp. <?php echo e($datas->harga); ?>

          </div>
          <p><a class="btn" href="<?php echo e($base_url); ?>/web/produk/<?php echo e($datas->id); ?>/buy">Beli</a></p>
        </div>
        <div class="card-reveal">
          <span class="card-title grey-text text-darken-4"><?php echo e($datas->name); ?><i class="material-icons right">close</i></span>
          <p><?php echo $datas->description; ?></p>
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
          <li><a href="<?php echo e($link); ?>list?page=1">First</a></li>
          <li><a href="<?php echo e($link); ?>list?page=<?php echo e($page->current_page-1); ?>"><<</a></li>
          <?php else: ?>
          <li class="disabled"><a class="disabled">First</a></li>
          <li class="disabled"><a class="disabled"><<</a></li>
          <?php endif; ?>

      <?php $x = $page->total_pages+1; ?>

      <?php for($i =1; $i<$x; $i++ ): ?>
          <?php if($page->current_page==$i): ?>
          <li class="active"><a href=""><?php echo e($i); ?></a></li>
          <?php else: ?>
          <li><a href="<?php echo e($link); ?>list?page=<?php echo e($i); ?>"><?php echo e($i); ?></a></li>
          <?php endif; ?>
      <?php endfor; ?>

          <?php if(isset($page->links->next)): ?>
          <li><a href="<?php echo e($link); ?>list?page=<?php echo e($page->current_pages+1); ?>">>></a></li>
          <li><a href="<?php echo e($link); ?>list?page=<?php echo e($page->total_pages); ?>">Last</a></li>
          <?php else: ?>
          <li class="disabled"><a>>></a></li>
          <li class="disabled"><a class="disabled">Last</a></li>
          <?php endif; ?>
      </ul>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.user.templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>