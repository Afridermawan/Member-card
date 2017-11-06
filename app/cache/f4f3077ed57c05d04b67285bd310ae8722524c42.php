<?php $__env->startSection('custom_script'); ?>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
    <script>
        $('.datepicker').pickadate({
          selectMonths: true, // Creates a dropdown to control month
          selectYears: 15, // Creates a dropdown of 15 years to control year,
          today: 'Today',
          clear: 'Clear',
          close: 'Ok',
          closeOnSelect: false // Close upon selecting a date,
        });
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="container">
  <div class="row">
    <nav style="border-radius: 25px;margin-top: 20px">
      <div class="nav-wrapper">
        <div class="col s12">
            <span style="font-family:  Tibetan Machine Uni, sans-serif;font-size: 25px;">Member-Card  &nbsp</span>
            <span style="font-family:  Trebuchet, sans-serif;font-size: 20px;"> <?php echo e($title); ?></span>
        </div>
      </div>
    </nav>
    <br>
  </div>
</div>

<div class="container">
    <form class="input-field col s12" action="<?php echo e($base_url); ?>/web/event/add/user" method="post"
        enctype="multipart/form-data">
        <div class="file-field input-field">
          <div class="btn">
           <span>File</span>
           <input type="file" name="image" multiple>
          </div>
          <div class="file-path-wrapper">
           <input class="file-path validate" type="text" placeholder="Upload one or more files">
          </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
              <input name="name" id="name" type="text" class="validate">
              <label for="title">Nama</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
              <input name="biaya_pendaftaran" id="biaya_pendaftaran" type="text" class="validate">
              <label for="title">Biaya Pendaftaran</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
              <input type="text" class="datepicker" name="start_date">
              <label for="title"></label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
              <textarea class="materialize-textarea" name="description"></textarea>
              <label for="content"></label>
            </div>
        </div>

        <div class="card-action center-align">
            <button class="btn waves-effect waves-light" type="submit" name="action">Simpan
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.user.templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>