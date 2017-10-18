<?php $__env->startSection('header-script'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="">

      <div class="page-title">
        <div class="title_left">
          <h3>Halaman</h3>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Edit Pengguna <small> <?php echo e($data->username); ?> </small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <br />
              <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action=" <?php echo e($base_url); ?>/admin/user/<?php echo e($data->id); ?>/edit " method="post" enctype="multipart/form-data">
                <div class="form-group has-feedback">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-username">Username <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="username" id="first-username" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo e($data->username); ?>" placeholder="Username">
                  </div>
                        <span class="help-block"></span>
                </div>

                <div class="form-group has-feedback">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="name" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo e($data->name); ?>" placeholder="name">
                  </div>
                        <span class="help-block"></span>
                </div>

                <div class="form-group has-feedback">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-email">Email <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="email" name="email" id="first-email" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo e($data->email); ?>" placeholder="Email">
                  </div>
                        <span class="help-block"></span>
                </div>

                <div class="form-group has-feedback">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-password">Password <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="password" name="password" id="first-password" required="required" class="form-control col-md-7 col-xs-12" value="" placeholder="Password">
                  </div>
                        <span class="help-block"></span>
                </div>

                <div class="form-group has-feedback">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-phone">Telepon <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="phone" id="first-phone" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo e($data->phone); ?>" placeholder="Telepon">
                  </div>
                        <span class="help-block"></span>
                </div>

                <div class="form-group has-feedback">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-email">Jenis Kelamin <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="gender">
                            <option value="Laki-laki" <?php if( $session->gender == Laki-laki ): ?> selected="selected" <?php endif; ?>>Laki-laki</option>
                            <option value="Perempuan" <?php if( $session->gender == Perempuan ): ?> selected="selected" <?php endif; ?>>Perempuan</option>
                        </select>
                  </div>
                </div>

                <div class="form-group has-feedback">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Alamat <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea name="address" class="textarea" rows="8" cols="40"><?php echo e($data->address); ?></textarea>
                  </div>
                        <span class="help-block"></span>
                </div>

                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" class="btn btn-success">Submit</button>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>