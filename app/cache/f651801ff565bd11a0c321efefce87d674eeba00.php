<?php $__env->startSection('custom_script'); ?>
<script>
  
  $(document).ready(function() {
    $('select').material_select();
  });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="container">
  <div class="row">
    <form class="col s12" action="<?php echo e($base_url); ?>/web/user/edit/<?php echo e($session->user_id); ?>/profile" method="post">
      <div class="row">
        <div class="input-field col s12">
          <input value="<?php echo e($session->username); ?>" name="username" id="username" type="text" class="validate">
          <label for="username">Username</label>
        </div>
        <div class="input-field col s12">
          <input value="<?php echo e($session->name); ?>" name="name" id="name" type="text" class="validate">
          <label for="name">name</label>
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
          <textarea class="materialize-textarea" name="address" data-length="120"><?php echo e($session->address); ?></textarea>
          <label for="address">Alamat</label> 
        </div>
      </div>
      <div class="row">  
        <div class="input-field col s12">
          <select name="gender" value="<?php echo e($session->gender); ?>">
            <option disabled selected>Choose your option</option>
            <option value="Laki-laki">Laki -laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
          <label>Jenis Kelamin</label>
        </div>
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