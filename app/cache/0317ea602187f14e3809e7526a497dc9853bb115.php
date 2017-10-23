<?php $__env->startSection('content'); ?>

  <div class="container">
    <div class="row">
    <div class="col s12 m12">
    <div class="card horizontal">
      <div class="card-image">
        <img src="<?php echo e($data->image); ?>" style="width: 200px;height: 200px">
      </div>
      <div class="card-stacked">
        <div class="card-content">
          <p>
            Name :<span style="float: right;"><?php echo e($data->name); ?></span> <br>
            Biaya Pendaftaran : <span style="float: right;"><?php echo e($data->biaya_pendaftaran); ?></span> <br>
          </p>
          <p>
          <form action="<?php echo e($base_url); ?>/web/event/<?php echo e($data->id); ?>/buy" method="post">
            <div class="row">
               <div class="input-field col s12">
                  <i class="material-icons prefix">add</i>
                  <input name="kuantitas" id="firstname" type="text" class="validate">
                  <label for="kuantitas" class="active">Kuantitas</label>
               </div>
            </div>
          </form>
          </p>
      </div>
    </div>
  </div>
  </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.user.templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>