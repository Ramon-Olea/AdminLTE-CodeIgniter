<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Log in (v2)</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="template/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="template/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="" class="h1"><b>Admin</b>LTE</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Inicia session</p>

                <form action="<?php echo base_url('/login') ?>" method="post">

                    <div class="mb-3 text-center">
                        <label class="form-label">Usuario <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg bg-white bg-opacity-5" name="usuario" placeholder="" required />
                    </div>
                    <div class="mb-3 text-center">
                        <label class="form-label">Contraseña <span class="text-danger">*</span></label>
                        <!--   <a href="#" class="ms-auto text-white text-decoration-none text-opacity-50">Forgot password?</a> -->
                        <input type="password" class="form-control form-control-lg bg-white bg-opacity-5" name="contra" placeholder="" required />
                    </div>
                    <!--  <div class="mb-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="customCheck1" />
        <label class="form-check-label" for="customCheck1">Remember me</label>
    </div>
</div> -->
                    <div class="text-white text-opacity-50 text-center mb-4">
                        <?php if (isset($mensaje)) : ?>
                            <div class="alert alert-danger alert-dismissable fade show p-1">
                                <p class="alert-heading"> <?php echo $mensaje; ?></p>

                            </div>
                        <?php endif; ?>


                    </div>
                    <button type="submit" class="btn btn-primary btn-block">ENTRAR</button>
                    <div class="text-center text-white text-opacity-50">
                        <!--  Don't have an account yet? <a href="page_register.html">Sign up</a>. -->
                    </div>
                    <br>
                </form>


                <!-- /.social-auth-links -->

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="template/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="template/dist/js/adminlte.min.js"></script>
</body>

</html>