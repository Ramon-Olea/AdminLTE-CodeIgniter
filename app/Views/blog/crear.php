<?= $this->extend('header');

?>
<!-- SE INCLUYE LA PLANTILLA -->
<?= $this->section('content') ?>
<br><br>
<div class="card card-info text-center">
    <div class="card-header ">
        <h3 class="card-title text-center">CREAR BLOG</h3>
    </div>


    <form action="<?php echo base_url('/registrarblog') ?>" method="POST">
        <div class="card-body">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Titulo</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Descripcion</label>
                <div class="col-sm-10">
                    <textarea id="editor" name="descripcion" rows="6" class="form-control"></textarea>

                </div>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-info">CREAR</button>
        </div>

    </form>
</div>

<?= $this->endSection() ?>