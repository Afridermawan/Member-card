<div class="top_nav">
  </span>
<?php echo e(print_r($notif->data)); ?>

  <div class="nav_menu">
    <nav class="" role="navigation">
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li class="">
          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          <?php
            $session = $_SESSION['login'];
          ?>
          <?php echo e($session->username); ?>


            <span class=" fa fa-angle-down"></span>
          </a>
          <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
            <li><a href="<?php echo e($base_url); ?>/admin/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
            </li>
          </ul>
        </li>

        <li role="presentation" class="dropdown">
          <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-envelope-o"></i>
            <span class="badge bg-green">
                <?php
                    // {{ $count->data }}
                ?>
            </span>
          </a>
          <ul id="menu1" class="dropdown-menu list-unstyled msg_list animated fadeInDown" role="menu">
            <?php $__currentLoopData = $notif->data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <a href="<?php echo e($link); ?>list">
                        <span class="image">
                            <img src="<?php echo e($request->image); ?>" alt="Profile Image" />
                        </span>
                        <span>
                            
                            
                        </span>
                        <span class="message">
                            <?php echo e($request->username); ?> meminta Permission untuk upgrade feature ..
                        </a>
                    </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <li>
              <div class="text-center">
                <a href="<?php echo e($link); ?>list">
                  <strong>See All Alerts</strong>
                  <i class="fa fa-angle-right"></i>
                </a>
              </div>
            </li>
          </ul>
        </li>

      </ul>
    </nav>
  </div>

</div>
