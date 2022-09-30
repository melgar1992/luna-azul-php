
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login! | </title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>application/assets/template/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url(); ?>application/assets/template/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url(); ?>application/assets/template/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo base_url(); ?>application/assets/template/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url(); ?>application/assets/template/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
        <div>
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="signin"></a>

            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <form action="<?php echo base_url(); ?>BaseController/login_process" method="post">
                            <h1>Ingreso </h1>
                            <?php if ($this->session->flashdata("error")) : ?>
                                <div class="alert alert-danger">
                                    <p><?php echo $this->session->flashdata("error"); ?></p>
                                </div>
                            <?php endif; ?>
                            <div>
                                <input type="text" name="username" class="form-control" placeholder="Username" required="required" />
                            </div>
                            <div>
                                <input type="password" name="password" class="form-control" placeholder="Password" required="required" />
                            </div>
                            <div>
                                <button class="btn btn-success" type="submit">Entrar</button>

                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">


                                <div class="clearfix"></div>
                                <br />

                                <div>
                                    <h1>Sistema </h1>

                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>
