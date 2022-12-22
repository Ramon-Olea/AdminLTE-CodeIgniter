<?= $this->extend('header');

?>
<!-- SE INCLUYE LA PLANTILLA -->
<?= $this->section('content') ?>

<div class="container">
  <div class="row">
    <div class="col-sm">
    <h1 class="page-header mb-0">Listado de Usuarios</h1>

    </div>
    <div class="col-sm">
    <a href="<?php echo base_url('/usercrear') ?>" class="btn btn-outline-theme"><i class="fa fa-plus-circle fa-fw me-1"></i> Crear Usuario</a>

    </div>
    <div class="col-sm">
    </div>
  </div>
</div>
        <div class="d-flex align-items-center mb-3">
            <div>

            </div>
            <div class="ms-auto">
            </div>
        </div>
        <br>
        <table class="table  table-striped" id="users-list">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">usuario</th>
                    <th scope="col">rol</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($datos as $key) : ?>

                    <tr>
                        <td><?= $key->id_usuario ?></td>
                        <td><?= $key->usuario ?></td>
                        <td><?= $key->rol ?></td>
                        <!--         <td> <a href="<?php echo base_url() . '/obteneruser/' . $key->id_usuario ?>" class="btn btn-warning">Editar</a></td> -->
                        <td><button href="#" type="button"  class="btn btn-info" id="boton<?= $key->id_usuario ?>" data-elemento<?= $key->id_usuario ?>="<?= $key->id_usuario ?>" data-bs-toggle="modal" data-bs-target="#modalCoverExample">Editar</button></td>
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




    <script>
       

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

        }else if (mensaje == '4') {
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
