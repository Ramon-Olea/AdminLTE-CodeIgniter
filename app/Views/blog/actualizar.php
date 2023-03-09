<?php

$this->include('funciones.php');
$consu_usuario = select_dato_where('t_usuarios', 'id_usuario', $_POST['id']);
/* precode($consu_usuario,0); */

?>
<div class="card card-info text-center">
    <div class="card-header ">
        <h3 class="card-title text-center">ACTUALIZAR USUARIO</h3>
    </div>

    <form action="<?php echo base_url('/actualizar') ?>" method="POST">

        <div class="card-body ">
            <div class="form-group row">
            <input type="hidden" name="id_usuario" value="<?= $consu_usuario['id_usuario'] ?>" />

                <label for="inputEmail3" class="col-sm-3 col-form-label">Usuario</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="usuario" value="<?= $consu_usuario['usuario'] ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-3 col-form-label">Contraseña</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="contra" name="contra" placeholder="Password"  value="<?= $consu_usuario['contra'] ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-3 col-form-label">Rol</label>
                <div class="col-sm-9">
                    <select class="form-control" name="rol" required>
                        <option value="">-- seleccione una opcion -- </option>
                        
                        <option value="general" <?php if (isset($consu_usuario['rol']) and $consu_usuario['rol'] == 'general') { ?>selected="selected" <?php } ?>>general</option>
                    <option value="sistemas" <?php if (isset($consu_usuario['rol']) and $consu_usuario['rol'] == 'sistemas') { ?>selected="selected" <?php } ?>>sistemas</option>
                    </select>

                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info">Actualizar</button>
        </div>

    </form>
</div>
