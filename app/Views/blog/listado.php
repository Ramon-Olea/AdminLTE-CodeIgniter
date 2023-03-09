<?= $this->extend('header');

?>
<!-- SE INCLUYE LA PLANTILLA -->
<?= $this->section('content') ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<br><br>


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>BLOG</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Icons</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header ">
                <h3 class="card-title"> <a href="<?php echo base_url('/crearblog') ?>"  class="btn btn-outline-danger btn-block"><i class="fa fa-book"></i>  Crear</a>
                </h3>
            </div>
            <div class="card-body">
                <table class="records_list table table-striped table-bordered table-hover" id="mydatatable">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">titulo</th>
                            <th scope="col">descripcion</th>
                            <th scope="col">Opciones</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">titulo</th>
                            <th scope="col">descripcion</th>
                            <th scope="col"></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($datos as $key) : ?>

                            <tr>
                                <td><?= $key->id ?></td>
                                <td><?= $key->titulo ?></td>
                                <td><?= $key->descripcion ?></td>
                                <!--         <td> <a href="<?php echo base_url() . '/obtenerblog/' . $key->id ?>" class="btn btn-warning">Editar</a></td> -->
                                <td><button href="#" type="button" class="btn btn-info" id="boton<?= $key->id ?>" data-elemento<?= $key->id ?>="<?= $key->id ?>" data-toggle="modal" data-target="#modalCoverExample">Editar</button><a href="<?php echo base_url() . '/blogeliminar/' . $key->id ?>" class="btn btn-danger">Eliminar</a></td>

                            </tr>

                            <div class="modal modal-cover fade" id="modalCoverExample">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <script>
                                            $(function() {

                                                $('#boton<?= $key->id ?>').click(function() {

                                                    var $this = $("#boton<?= $key->id ?>").data("elemento<?= $key->id ?>"); //submit button selector using ID

                                                    const misDatos = "id=" + $this;
                                                    enviarDatosPorAjax(misDatos, "<?php echo base_url('/blogactualizar') ?>", function(respuesta) {
                                                        const resultado = document.getElementById("result");
                                                        resultado.innerHTML = respuesta;
                                                    });

                                                });
                                            });
                                        </script>
                                        <div id="result"></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>



<script>
    $(function() {
        DatatableFilters('mydatatable');

        $('#mydatatable_info').hide();

        let mensaje = '<?php echo $mensaje; ?>';
        if (mensaje == '1') {
            Toast('success', 'Agregado con exito');


        } else if (mensaje == '0') {


            Toast('error', 'error no se agrego el titulo');


        } else if (mensaje == '2') {


            Toast('success', 'actualizado con exito');


        } else if (mensaje == '3') {


            Toast('error', 'error no se actualizo el titulo');


        } else if (mensaje == '4') {


            Toast('success', 'titulo eliminado');


        } else if (mensaje == '5') {

            Toast('error', 'error no se borro el titulo');

        }
    });
</script>

<?= $this->endSection() ?>