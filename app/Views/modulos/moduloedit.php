<?= $this->include('header');



?>
<!-- SE INCLUYE LA PLANTILLA -->

<div class="register">

    <div class="register-content text-center">
        <?php foreach ($datos as $key) : ?>

            <form action="<?php echo base_url('/dataeditarmodulo') ?>" method="POST">
                <h1 class="text-center">Editar Submodulo</h1>

                <input type="hidden" value="<?= $key->id_submodulo ?>" name="id_submodulo">
                <div class="mb-3">
                    <label class="form-label">Modulo <span class="text-danger">*</span></label>
                    <select class="form-select form-select-lg bg-white bg-opacity-5" name="Modulo" readonly>
                        <option value="<?= $key->Modulo ?>" selected><?= $key->modulo ?></option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Submodulo <span class="text-danger">*</span></label>
                    <input type="text" name="Submodulo" class="form-control form-control-lg bg-white bg-opacity-5" value="<?= $key->Submodulo ?>" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Archivo <span class="text-danger">*</span></label>
                    <input type="text" name="Archivo" class="form-control form-control-lg bg-white bg-opacity-5" required value="<?= $key->Archivo ?>" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Icono <span class="text-danger">*</span></label>
                    <input type="text" name="Icono" class="form-control form-control-lg bg-white bg-opacity-5" required value="<?= $key->Icono ?>" />
                </div>
                <div class="mb-3 ">
                    <label class="form-label">Activo <span class="text-danger"></span></label>
                    <select class="form-select form-select-lg bg-white bg-opacity-5" name="Activo" required>
                        <option value="si" <?= $key->Activo == "si" ? "selected" : "" ?>>si</option>
                        <option value="no" <?= $key->Activo == "no" ? "selected" : "" ?>>no</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <a href="javascript:window.history.back();" class="btn btn-danger btn-lg d-block w-100">REGRESAR</a>


                    </div>
                    <div class="col-md-6">

                        <button type="submit" class="btn btn-outline-theme btn-lg d-block w-100">Guardar</button>
                    </div>
                </div>
            </form>
        <?php endforeach; ?>

    </div>

</div>