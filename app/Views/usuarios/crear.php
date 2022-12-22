<?= $this->include('header')  ?>
<!-- SE INCLUYE LA PLANTILLA -->

<div class="register">

    <div class="register-content">
        <form action="<?php echo base_url('/registrar')?>" method="POST">
            <h1 class="text-center">Crear Usuario</h1>
            <div class="mb-3">
                <label class="form-label">Usuario <span class="text-danger">*</span></label>
                <input type="text" name="usuario" class="form-control form-control-lg bg-white bg-opacity-5" value="" required/>
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña <span class="text-danger">*</span></label>
                <input type="password" name="contra" class="form-control form-control-lg bg-white bg-opacity-5" value="" required />
            </div>

            <div class="mb-3">
                <label class="form-label">Rol <span class="text-danger">*</span></label>
                <select class="form-select form-select-lg bg-white bg-opacity-5" name="rol" required>
                  <option  value="">-- seleccione una opcion -- </option>
                    <option  value="general">general</option>
                    <option  value="sistemas">sistemas</option>

                </select>
            </div>
          
            <div class="mb-3">
                <button type="submit" class="btn btn-outline-theme btn-lg d-block w-100">CREAR</button>
            </div>
            
        </form>
    </div>

</div>