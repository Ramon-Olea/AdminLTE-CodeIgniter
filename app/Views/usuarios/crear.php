<?= $this->extend('header');

?>
<!-- SE INCLUYE LA PLANTILLA -->
<?= $this->section('content') ?>
<br><br>
<div class="card card-info text-center">
    <div class="card-header ">
        <h3 class="card-title text-center">CREAR USUARIO</h3>
    </div>


    <form action="<?php echo base_url('/registrar') ?>" method="POST">
        <div class="card-body">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Usuario</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="usuario" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Contraseña</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="contra" name="contra" placeholder="Password" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Rol</label>
                <div class="col-sm-10">
                    <select class="form-control" name="rol" required>
                        <option value="">-- seleccione una opcion -- </option>
                        <option value="general">general</option>
                        <option value="sistemas">sistemas</option>

                    </select>

                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info">CREAR</button>
        </div>

    </form>
</div>

<?= $this->endSection() ?>