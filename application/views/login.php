<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Campassador ">
    <meta name="keyword" content="Dell, Campassador ">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>DELL | Login</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/bootstrap-reset.css'); ?>" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url('assets/assets/font-awesome/css/font-awesome.css'); ?>" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style-responsive.css'); ?>" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-body">

    <div class="container">

      <form class="form-signin" method="post" action="<?php echo site_url('login/validate') ;?>">
	  <?php if(isset($alerterror)) { ?>
            <div class="alert alert-danger">
            <?php echo $alerterror;	?>
            </div>
            <?php } ?>
            <div class="login-logo">
            <img src="<?php echo base_url('assets/images/dell_login.png'); ?>" alt="Dell" />
            <img src="<?php echo base_url('assets/images/campassador.png'); ?>" alt="Campassador" />
            </div>
        <h2 class="form-signin-heading">Campassador</h2>
        <h2 class="form-signin-heading">Dell</h2>

        <div class="login-wrap">
            <input type="text" class="form-control" placeholder="Username" autofocus name="username">
            <input type="password" class="form-control" placeholder="Password" name="password">
            <label class="checkbox">
                <!--<input type="checkbox" value="remember-me"> Remember me
                <span class="pull-right"> <a href="#"> Forgot Password?</a></span>
            </label>-->
            <button class="btn btn-lg btn-login btn-self" type="submit">Login</button>
            <!--<p>or you can sign in via social network</p>
            <div class="login-social-link">
                <a href="index.html" class="facebook">
                    <i class="icon-facebook"></i>
                    Facebook
                </a>
                <a href="index.html" class="twitter">
                    <i class="icon-twitter"></i>
                    Twitter
                </a>
            </div>-->

        </div>

      </form>

    </div>


  </body>
</html>