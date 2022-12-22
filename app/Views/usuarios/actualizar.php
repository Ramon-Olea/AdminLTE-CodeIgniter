<?php

$this->include('funciones.php');
$consu_usuario = select_dato_where('t_usuarios', 'id_usuario', $_POST['id']);
/* precode($consu_usuario,0); */

?>
<div class="register">
    <div class="register-content">
        <form action="<?php echo base_url('/actualizar') ?>" method="POST">
            <input type="hidden" name="id_usuario" value="<?= $consu_usuario['id_usuario'] ?>" />

            <h1 class="text-center">Actualizar Usuario</h1>
            <div class="mb-3">
                <label class="form-label">Usuario <span class="text-danger">*</span></label>
                <input type="text" name="usuario" class="form-control form-control-lg bg-white bg-opacity-5" value="<?= $consu_usuario['usuario'] ?>" required />
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña <span class="text-danger">*</span></label>
                <input type="text" name="contra" class="form-control form-control-lg bg-white bg-opacity-5" value="<?= $consu_usuario['contra'] ?>" required />
            </div>

            <div class="mb-3">
                <label class="form-label">Rol <span class="text-danger">*</span></label>
                <select class="form-select form-select-lg bg-white bg-opacity-5" name="rol" required>
                    <option value="<?= $consu_usuario['rol'] ?>"><?= $consu_usuario['rol'] ?> </option>
                    <option value="general" <?php if (isset($consu_usuario['rol']) and $consu_usuario['rol'] == 'general') { ?>selected="selected" <?php } ?>>general</option>
                    <option value="sistemas" <?php if (isset($consu_usuario['rol']) and $consu_usuario['rol'] == 'sistemas') { ?>selected="selected" <?php } ?>>sistemas</option>

                </select>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-outline-theme btn-lg d-block w-100">Actualizar</button>
            </div>

        </form>
    </div>

</div>