<!DOCTYPE html>
<html lang="en"> 

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Member Card | <?php echo e($title); ?> </title>

    <!-- Bootstrap core CSS -->
    <?php echo $__env->make('backend.user.templates.partials.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  </head>

  <body class="center">

    <div class="valign-wrapper" style="width:100%;height:100%;position: absolute;">
        <div class="valign" style="width:100%;">
            <div class="container">
              <?php echo $__env->make('backend.user.templates.partials.alerts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
               <div class="row">
                  <div class="col s12 m6 offset-m3">
                     <div class="card" style="border-radius: 25px;box-shadow: 2px 2px 4px #000000;background: #fafafa">
                        <div class="card-content">
                           <span class="card-title black-text">Silahkan masukkan Email akun Member Card Anda, lalu masukkan password baru</span>
                           <form action="<?php echo e($base_url); ?>/password/reset" method="post">
                              <div class="row">
                                 <div class="input-field col s12">
                                    <i class="material-icons prefix">person_outline</i>
                                    <input name="email" id="firstname" type="text" class="validate">
                                    <label for="email" class="active">email</label>
                                 </div>
                              </div>
                                <div class="row">
                                 <div class="input-field col s12">
                                    <i class="material-icons prefix">lock</i>
                                    <input name="password" id="password" type="password" class="validate">
                                    <label for="password" class="active">Password Baru</label>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="input-field col s12">
                                    <i class="material-icons prefix">lock</i>
                                    <input type="hidden" name="token" value="<?php echo e($data); ?>">
                                    <input name="password2" id="password2" type="password" class="validate">
                                    <label for="password2" class="active">Ulangi Password</label>
                                 </div>
                              </div>
                              <div class="card-action">
                                <button class="btn waves-effect waves-light" type="submit" name="action">Reset Password
                                </button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('backend.user.templates.partials.script', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </body>
</html>
