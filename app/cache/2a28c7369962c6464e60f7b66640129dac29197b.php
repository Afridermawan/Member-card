<?php $__env->startSection('content'); ?>

  <div class="container">
    <div class="row">
    <div class="col s12 m12">
    <div class="card horizontal">
      <div class="card-image">
        <img src="<?php echo e($produk->image); ?>" style="width: 200px;height: 200px">
      </div>
      <div class="card-stacked">
        <div class="card-content">
          <p>
            Name :<span style="float: right;"><?php echo e($produk->name); ?></span> <br>
            Harga :<span style="float: right;"> <?php echo e($produk->harga); ?></span><br>
            kuantitas :<span style="float: right;"> <?php echo e($produk->kuantitas); ?></span>
          </p>
          <hr>
          <p>
            Total :<span style="float: right;"> <?php echo e($produk->total_harga); ?></span>
          </p>
        <div class="card-action">
          <a href="<?php echo e($base_url); ?>/web/produk/bayar"><i class="material-icons">payment</i> &nbsp Lanjutkan Pembayaran</a>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>  
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.user.templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>