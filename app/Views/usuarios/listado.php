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
                                $(document).ready(function() {

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
    $(document).ready(function() {
        $('#mydatatable tfoot th').each(function() {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Filtrar.." />');
        });

        var table = $('#mydatatable').DataTable({
            "dom": 'B<"float-left"i><"float-right"f>t<"float-left"l><"float-right"p><"clearfix">',
            "responsive": false,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "order": [
                [0, "desc"]
            ],
            "initComplete": function() {
                this.api().columns().every(function() {
                    var that = this;

                    $('input', this.footer()).on('keyup change', function() {
                        if (that.search() !== this.value) {
                            that
                                .search(this.value)
                                .draw();
                        }
                    });
                })
            }
        });
    });


    let mensaje = '<?php echo $mensaje; ?>';
    if (mensaje == '1') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: 'Agregado con exito'
        })
    } else if (mensaje == '0') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: 'error no se agrego el usuario'
        })

    } else if (mensaje == '2') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: 'usuario actualizado'
        })

    } else if (mensaje == '3') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: 'error no se actualizo el usuario'
        })

    } else if (mensaje == '4') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: 'usuario eliminado'
        })

    } else if (mensaje == '5') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: 'error no se borro el usuario'
        })

    }
</script>

<?= $this->endSection() ?>