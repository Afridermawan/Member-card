<?php $__env->startSection('custom_script'); ?>
<script>

  $(document).ready(function() {
    $('select').material_select();
  });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php echo e(dd($payment_method->data[0]->id)); ?>

<div class="container">
  <div class="row">
    <form class="col s12" action="<?php echo e($base_url); ?>/web/deposit/kredit" method="post">
      <div class="row">
        <div class="input-field col s12">
          <input value="<?php echo e($session->username); ?>" name="username" id="name" type="text" class="validate">
          <label for="username">username</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input value="<?php echo e($session->email); ?>" name="email" id="email" type="email" class="validate">
          <label for="email">Email</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input value="<?php echo e($session->phone); ?>" name="phone" id="phone" type="text" class="validate">
          <label for="phone">No.telepon</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <select name="payment_method">
              <?php $__currentLoopData = $payment_method->data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($payment->id); ?>"><?php echo e($payment->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
          <label>Jenis pembayaran</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input name="total" id="total" type="number" class="validate">
          <label for="total">Jumlah</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <textarea class="materialize-textarea" name="description" data-length="120"></textarea>
          <label for="address">Deskripsi</label>
        </div>
      </div>
      <div class="card-action center-align">
        <button class="btn waves-effect waves-light" type="submit" name="action">Deposit
        </button>
      </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.user.templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>