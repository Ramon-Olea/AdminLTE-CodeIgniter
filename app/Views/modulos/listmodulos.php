<?= $this->extend('header');

?>
    <!-- SE INCLUYE LA PLANTILLA -->
  <?= $this->section('content') ?>
        <script type="text/javascript" language="javascript" src="<?= base_url('/') ?>/assets/js/funciones.js"></script> <!-- SE INCLUYE LA PLANTILLA -->

        <div class="d-flex align-items-center mb-3">
            <div>

                <h1 class="page-header mb-0">Listado de Submodulos</h1>
            </div>
            <div class="ms-auto">
                <a href="<?php echo base_url('/modulocrear') ?>" class="btn btn-outline-theme"><i class="fa fa-plus-circle fa-fw me-1"></i> Crear Submodulo</a>
            </div>
        </div>
        <br>
			<div class="table-responsive">

        <table class="table  table-striped  dataTable no-footer " id="modulos-list">
            <thead>
                <tr>
                    <!--       <th scope="col">#</th> -->
                    <th scope="col">Submodulo</th>
                    <th scope="col">Modulo</th>
                    <th scope="col">Archivo</th>
                    <th scope="col">Icono</th>
                    <th scope="col">Activo</th>
                    <th>OPCIONES</th>

                </tr>
            </thead>
         
        </table>
        </div>

        <script>
			$(document).ready(function() {
				InitialDatatableServer('table','<?php echo base_url('/select_serverside'); ?>');

			});
            
            $('.table-responsive').floatingScroll();
		</script>
        <script>
            
           
            let mensaje = '<?php echo $mensaje; ?>';
            if (mensaje == '1') {
                Toast("success", 'Agregado con exito')

            } else if (mensaje == '0') {

                Toast("error", 'Error no se agrego el modulo')

            } else if (mensaje == '2') {
                Toast("success", 'Actualizado con exito')


            }
        </script>


    <?= $this->endSection() ?>