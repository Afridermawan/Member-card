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

  <link href="<?php echo e($base_url); ?>/assets/css/bootstrap.min.css" rel="stylesheet">

  <link href="<?php echo e($base_url); ?>/assets/fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo e($base_url); ?>/assets/css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="<?php echo e($base_url); ?>/assets/css/custom.css" rel="stylesheet">
  <link href="<?php echo e($base_url); ?>/assets/css/icheck/flat/green.css" rel="stylesheet">

  <script src="<?php echo e($base_url); ?>/assets/js/jquery.min.js"></script>

</head>

<body style="background:#F7F7F7;">
<?php echo $__env->make('templates.partials.alerts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <div class="">
    <div id="wrapper">
      <div id="login" class="animate form">
        <section class="login_content">
          <form action="<?php echo e($base_url); ?>/mc-admin" method="post">
            <h1>Masuk Member Card Apps</h1>
            <div>
              <input type="text" name="username" class="form-control" placeholder="Username" required="" value="" />
            </div>
            <div>
              <input type="password" name="password" class="form-control" placeholder="Kata Sandi" required="" />
            </div>
            <div>
                <button type="submit" class="btn btn-default btn-submit">Masuk</button>
            </div>
            <div class="clearfix"></div>
            <div class="separator">
          </form>
          <!-- form -->
        </section>
        <!-- content -->
      </div>

    </div>
  </div>
  <script src="<?php echo e($base_url); ?>/assets/js/bootstrap.min.js"></script>

</body>

</html>
