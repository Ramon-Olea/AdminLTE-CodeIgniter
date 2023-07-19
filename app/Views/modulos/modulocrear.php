<?= $this->include('header');

?>
<!-- SE INCLUYE LA PLANTILLA -->

<div class="register">

    <div class="register-content text-center">
        <form action="<?php echo base_url('/registrarmodulo') ?>" method="POST">
            <h1 class="text-center">Crear Submodulo</h1>


            <div class="mb-3">
                <label class="form-label">Modulo <span class="text-danger">*</span></label>
                <select class="form-select form-select-lg bg-white bg-opacity-5" name="Modulo" required>
                    <option value="">-- seleccione una opcion -- </option>

                    <?php foreach ($datos as $key) : ?>
                        <option value="<?= $key->id_modulo ?>"><?= $key->modulo ?></option>

                    <?php endforeach; ?>

                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Submodulo <span class="text-danger">*</span></label>
                <input type="text" name="Submodulo" class="form-control form-control-lg bg-white bg-opacity-5" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Archivo <span class="text-danger">*</span></label>
                <input type="text" name="Archivo" class="form-control form-control-lg bg-white bg-opacity-5" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Icono <span class="text-danger">*</span></label>
                <input type="text" name="Icono" class="form-control form-control-lg bg-white bg-opacity-5" required />
            </div>
            <div class="mb-3 ">
                <label class="form-label">Activo <span class="text-danger"></span></label>
                <select class="form-select form-select-lg bg-white bg-opacity-5" name="Activo" required>
                    <option value="si">si</option>
                    <option value="no">no</option>

                </select>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-outline-theme btn-lg d-block w-100">CREAR</button>
            </div>

        </form>
    </div>

</div>