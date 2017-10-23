<?php $__env->startSection('content'); ?>

  <div class="container">
    <div class="row">
    <div class="col s12 m12">
    <div class="card horizontal">
      <div class="card-image">
        <img src="<?php echo e($event->image); ?>" style="width: 200px;height: 200px">
      </div>
      <div class="card-stacked">
        <div class="card-content">
          <p>
            Name :<span style="float: right;"><?php echo e($event->name); ?></span> <br>
            Biaya Pendaftaran :<span style="float: right;"> <?php echo e($event->biaya_pendaftaran); ?></span><br>
            kuantitas :<span style="float: right;"> <?php echo e($event->kuantitas); ?></span>
          </p>
          <hr>
          <p>
            Total :<span style="float: right;"> <?php echo e($event->total_harga); ?></span>
          </p>
        <div class="card-action">
          <a href="<?php echo e($base_url); ?>/web/event/<?php echo e($event->id); ?>/pay"><i class="material-icons">payment</i> &nbsp Lanjutkan Pembayaran</a>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.user.templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>