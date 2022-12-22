<?php
$this->include('header');
$this->include('funciones.php');

$consu_usuario = select_dato_where('t_usuarios', 'id_usuario', session('id_usuario'));
/* precode($consu_usuario,0); */

?>
<link href="<?= base_url('/') ?>/assets/css/vendor.min.css" rel="stylesheet" />
<link href="<?= base_url('/') ?>/assets/css/app.min.css" rel="stylesheet" />


<link href="<?= base_url('/') ?>/assets/plugins/jvectormap-next/jquery-jvectormap.css" rel="stylesheet" />
<div class="register">
    <div class="register-content">
        <form action="<?php echo base_url('/actualizarperfil') ?>" method="POST"  enctype="multipart/form-data">
            <input type="hidden" name="id_usuario" value="<?= $consu_usuario['id_usuario'] ?>" />

            <h1 class="text-center">Actualizar Usuario</h1>
            <div class="mb-3 text-center">
                <label class="form-label">Usuario <span class="text-danger">*</span></label>
                <input type="text" name="usuario" class="form-control form-control-lg bg-white bg-opacity-5" value="<?= $consu_usuario['usuario'] ?>" required />
            </div>

            <div class="mb-3 text-center">
                <label class="form-label">Contraseña <span class="text-danger">*</span></label>
                <input type="text" name="contra" class="form-control form-control-lg bg-white bg-opacity-5" value="<?= $consu_usuario['contra'] ?>" required />
            </div>

            <div class="mb-3 text-center">
                <label class="form-label">Foto<span class="text-danger"></span></label>
                <br>
                <?= $imagen =  $consu_usuario['foto'] != '' ? '<img src="data:image/png;base64,' .  $consu_usuario['foto'] . '"  class="img-responsive" height="60px"/>' : '<img src="assets/img/user/default_user.png" height="60px" />'; ?>
                <br>
                <br>

                <input type="file" name="foto" class="form-control form-control-lg bg-white bg-opacity-5" value="<?= $consu_usuario['foto'] ?>" />
                <span> si no selecciona foto se usara la anterior</span>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <a href="javascript:window.history.back();" class="btn btn-danger btn-lg d-block w-100">REGRESAR</a>


                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-outline-theme btn-lg d-block w-100">Actualizar</button>

                </div>

            </div>
            <div class="mb-3">

            </div>

        </form>
    </div>

</div>