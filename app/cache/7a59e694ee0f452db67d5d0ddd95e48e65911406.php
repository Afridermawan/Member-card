<?php $__env->startSection('content'); ?>

  <div class="container">
    <div class="row">
    <div class="col s12 m12">
    <div class="card horizontal">
      <div class="card-image" style="background: #EEEEEE">
        <a class="modal-trigger" href="#modal2"><img src="<?php echo e($session->image); ?>" style="width: 250px;height: 350px"></a>
      </div>
      <div class="card-stacked">
        <div class="card-content">
          <p>
            Name : <?php echo e($session->name); ?><br>
            Username : <?php echo e($session->username); ?><br>
            Email : <?php echo e($session->email); ?><br>
            No.Telepon : <?php echo e($session->phone); ?><br>
            Jenis Kelamin : <?php echo e($session->gender); ?><br>
            Address : <?php echo $session->address; ?><br>
            PIN : <?php echo e($_SESSION['pin']); ?>


          </p>
          <span style="float: right;">
            <!-- Modal Trigger -->
              <a class="waves-effect waves-light btn modal-trigger" href="#modal1">QR-Code</a>
            <!-- Modal Structure -->
            <div class="col s3 center-align">

            <div id="modal1" class="modal">
              <div class="modal-content">
              <img src="<?php echo e($session->code); ?>" style="width: 250px;height: 250px">
              </div>
            </div>
            </div>
            </div>
          </span>
        <div class="card-action">
        <?php if(isset( $_SESSION['pin'] )): ?>
          <a class="modal-trigger" href="#modal3"><i class="material-icons">create</i> &nbsp Edit PIN</a>
        <?php else: ?>
          <a class="modal-trigger" href="#modal3"><i class="material-icons">create</i> &nbsp Add PIN</a>
        <?php endif; ?>
          <a href="<?php echo e($base_url); ?>/web/user/edit/<?php echo e($session->id); ?>/profile"><i class="material-icons">settings</i>&nbsp Setting Profile</a>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
  <span style="float: right;">
  <!-- Modal Structure -->
  <div class="col s3 center-align">

  <div id="modal2" class="modal">
    <div class="modal-content">
        <form action="<?php echo e($base_url); ?>/web/user/change/image" method="post" enctype="multipart/form-data">
          <div class="file-field input-field">
            <div class="btn">
              <span>File</span>
              <input type="file" name="image" multiple>
            </div>
            <div class="file-path-wrapper">
              <input name="img" class="file-path validate" type="text" placeholder="Upload one or more files">
            </div>
          </div>
          <div class="card-action center-align">
            <button class="btn waves-effect waves-light" type="submit" name="action">Edit
            </button>
          </div>
        </form>
    </div>
  </div>
  </div>
  </div>
</span>

<span style="float: right;">
<!-- Modal Structure -->
<div class="col s3 center-align">
<div id="modal3" class="modal">
  <div class="modal-content">
      <form action="<?php echo e($base_url); ?>/web/pin/check/password" method="post">
          <div class="row">
            <div class="input-field col s12">
              <input name="password" id="password" type="password" class="validate">
              <label for="password"><i class="material-icons">lock_outline</i> Password</label>
            </div>
          </div>
      </form>
  </div>
</div>
</div>
</div>
</span>
<?php $__env->startSection('custom_script'); ?>
  <script>
    $(document).ready(function(){
      $('#modal1').modal();
      });
  </script>
  <script>
    $(document).ready(function(){
      $('#modal2').modal();
      });
  </script>
  <script>
    $(document).ready(function(){
      $('#modal3').modal();
      });
  </script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.user.templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>