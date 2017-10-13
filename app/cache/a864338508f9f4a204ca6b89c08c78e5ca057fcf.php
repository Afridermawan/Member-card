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
                           <span class="card-title black-text">Silahkan Masukan Email Anda</span>
                           <form action="<?php echo e($base_url); ?>/reset" method="post">
                              <div class="row">
                                 <div class="input-field col s12">
                                    <i class="material-icons prefix">email</i>
                                    <input name="email" id="lastname" type="email" class="validate">
                                    <label for="email" class="active">Email</label>
                                 </div>
                              </div>
                              <div class="card-action">
                                <button class="btn waves-effect waves-light" type="submit" name="action">Kirim
                                </button>
                              </div>
                           </form>
                        </div>
                     </div>
                    <div>
                      <p class="pull-left text-xs-center m-0"><a href="<?php echo e($base_url); ?>/" class="btn red">Kembali Login</a></p>
                    </div>
                  </div>
               </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('backend.user.templates.partials.script', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </body>
</html>
