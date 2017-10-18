<?php $__env->startSection('content'); ?>
    <div class="">

      <div class="page-title">
        <div class="title_left">
          <h3>
                Komentar
                <small>
                    Member Card Apps
                </small>
            </h3>
        </div>
      </div>
      <div class="clearfix"></div>

      <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <table class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Judul</th>
                      <th>Nama</th>
                      <th>Komentar</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $key = 1;
                    ?>
                    <?php $__currentLoopData = $data->data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $datas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td> <?php echo e($key++); ?></td>
                            <td> <?php echo e($datas->title); ?> </td>
                            <td> <?php echo e($datas->username); ?> </td>
                            <td> <?php echo e($datas->comment); ?> </td>
                            <?php if($datas->user_id > 1): ?>
                            <td>
                                <a href="<?php echo e($link.$datas->id.'/comment/admin'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Balas</a>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>