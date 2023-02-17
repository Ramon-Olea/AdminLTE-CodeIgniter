<?= $this->extend('header');

?>
<!-- SE INCLUYE LA PLANTILLA -->
<?= $this->section('content') ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<br><br>
<div class="card card-info text-center">
    <div class="card-header ">
        <h3 class="card-title text-center">Listado de Usuarios</h3>

    </div>
    <br>
    <a href="<?php echo base_url('/usercrear') ?>" class="btn btn-light"><i class="fa fa-plus-circle fa-fw me-1"></i> Crear Usuario</a>

    <div class="table-responsive" id="mydatatable-container">
        <table class="records_list table table-striped table-bordered table-hover" id="mydatatable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">usuario</th>
                    <th scope="col">rol</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>

                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">usuario</th>
                    <th scope="col">rol</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($datos as $key) : ?>

                    <tr>
                        <td><?= $key->id_usuario ?></td>
                        <td><?= $key->usuario ?></td>
                        <td><?= $key->rol ?></td>
                        <!--         <td> <a href="<?php echo base_url() . '/obteneruser/' . $key->id_usuario ?>" class="btn btn-warning">Editar</a></td> -->
                        <td><button href="#" type="button" class="btn btn-info" id="boton<?= $key->id_usuario ?>" data-elemento<?= $key->id_usuario ?>="<?= $key->id_usuario ?>" data-toggle="modal" data-target="#modalCoverExample">Editar</button></td>
                        <td> <a href="<?php echo base_url() . '/usereliminar/' . $key->id_usuario ?>" class="btn btn-danger">Eliminar</a></td>

                    </tr>

                    <div class="modal modal-cover fade" id="modalCoverExample">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <script>
                                      $(function() {

                                        $('#boton<?= $key->id_usuario ?>').click(function() {

                                            var $this = $("#boton<?= $key->id_usuario ?>").data("elemento<?= $key->id_usuario ?>"); //submit button selector using ID
                                            // Ajax config
                                            $.ajax({
                                                type: "POST",
                                                url: "<?php echo base_url('/useractualizar') ?>",
                                                data: "id=" + $this,
                                                dataType: "html",
                                                sync: false,
                                                beforeSend: function() {
                                                    //imagen de carga
                                                    $("#result").html("<p align='center'><div class='spinner-grow text-primary'></div></p>");
                                                },
                                                error: function() {
                                                    alert("error peticion ajax");
                                                },
                                                success: function(data) {
                                                    $("#result").empty();
                                                    $("#result").append(data);
                                                }
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


<script>
    $(function() {
        DatatableFilters('mydatatable');



        let mensaje = '<?php echo $mensaje; ?>';
        if (mensaje == '1') {
            Toast('success', 'Agregado con exito');


        } else if (mensaje == '0') {


            Toast('error', 'error no se agrego el usuario');


        } else if (mensaje == '2') {


            Toast('success', 'actualizado con exito');


        } else if (mensaje == '3') {


            Toast('error', 'error no se actualizo el usuario');


        } else if (mensaje == '4') {


            Toast('success', 'usuario eliminado');


        } else if (mensaje == '5') {

            Toast('error', 'error no se borro el usuario');

        }
    });
</script>

<?= $this->endSection() ?>