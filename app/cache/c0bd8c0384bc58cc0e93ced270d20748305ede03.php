<?php $__env->startSection('content'); ?>
    <div class="">

      <div class="page-title">
        <div class="title_left">
          <h3>
                Daftar Produk
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

            <div class="x_content">

                <table class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Image</th>
                      <th>Nama</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php $__currentLoopData = $data->data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $datas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td> <?php echo e($key+1); ?></td>
                            <td><img src="<?php echo e($datas->image); ?>" alt="" width="50px" height="50px"></td>
                            <td> <?php echo e($datas->username); ?> </td>
                            <td>
                                <a href="<?php echo e($link.$datas->id.'/approve'); ?>" class="btn btn-default btn-sm">Terima</a>
                                <a href="<?php echo e($link.$datas->id.'/delete'); ?>" class="btn btn-danger btn-sm">Tolak</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
                </table>

            <?php if(isset($data->meta->pagination)): ?>
                <?php
                $page = $data->meta->pagination;
                ?>
                <p class="pull-left"><br><b>Total Data : <?php echo e($page->total); ?></b></p>
                <ul class="pagination pull-right">
                    <?php if(isset($page->links->previous)): ?>
                    <li><a href="<?php echo e($link); ?>list?page=1">First</a></li>
                    <li><a href="<?php echo e($link); ?>list?page=<?php echo e($page->current_page-1); ?>"><<</a></li>
                    <?php else: ?>
                    <li class="disabled"><a class="disabled">First</a></li>
                    <li class="disabled"><a class="disabled"><<</a></li>
                    <?php endif; ?>

                <?php $x = $page->total_pages+1; ?>

                <?php for($i =1; $i<$x; $i++ ): ?>
                    <?php if($page->current_page==$i): ?>
                    <li class="active"><a href=""><?php echo e($i); ?></a></li>
                    <?php else: ?>
                    <li><a href="<?php echo e($link); ?>list?page=<?php echo e($i); ?>"><?php echo e($i); ?></a></li>
                    <?php endif; ?>
                <?php endfor; ?>

                    <?php if(isset($page->links->next)): ?>
                    <li><a href="<?php echo e($link); ?>list?page=<?php echo e($page->current_pages+1); ?>">>></a></li>
                    <li><a href="<?php echo e($link); ?>list?page=<?php echo e($page->total_pages); ?>">Last</a></li>
                    <?php else: ?>
                    <li class="disabled"><a>>></a></li>
                    <li class="disabled"><a class="disabled">Last</a></li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
              </div>
            </div>
          </div>

        </div>
      </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>