<?php $__env->startSection('custom_script'); ?>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
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
    <form class="input-field col s12" action="<?php echo e($base_url); ?>/web/article/create/user" method="post"
        enctype="multipart/form-data">
        <div class="file-field input-field">
          <div class="btn">
           <span>File</span>
           <input type="file" name="thumbnail" multiple>
          </div>
          <div class="file-path-wrapper">
           <input class="file-path validate" type="text" placeholder="Upload one or more files">
          </div>
        </div>
        <div class="row">
        <div class="input-field col s12">
          <input name="title" id="title" type="text" class="validate">
          <label for="title">Title</label>
        </div>
    </div>
        <div class="row">
        <div class="input-field col s12">
          <textarea class="materialize-textarea" name="content"></textarea>
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