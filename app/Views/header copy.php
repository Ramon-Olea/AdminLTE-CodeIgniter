<?php

/**
 * @author     🆁🅼🅽
 * @copyright 28/02/2024
 * @empresa FIBREMEX
 * 
 * 
 *$variable = isset($_POST['status_ac']) ? $_POST['status_ac'] : "";
 *   list($var1, $var2) = explode(',', $_POST['id_area']);
 */

use CodeIgniter\Database\Query;

$id_usuario =   session('id_usuario');
function db_query2($query)
{
	$host = 'localhost';
	$db = 'rmn';
	$user = 'root';
	$pass = '';
	$conexion = new mysqli($host, $user, $pass, $db);

	$result = mysqli_query($conexion, $query);
	return $result;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AdminLTE 3 </title>
	


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  
    <link href="<?= base_url('/') ?>/assets/plugins/bootstrap-table/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="<?= base_url('/') ?>/assets/plugins/bootstrap-table/dist/bootstrap-table.min.js"></script>
    <script src="<?= base_url('/') ?>/assets/plugins/bootstrap-table/dist/bootstrap-table.min.js"></script>

    <!-- required js -->
    <script src="<?= base_url('/') ?>/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('/') ?>/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?= base_url('/') ?>/assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url('/') ?>/assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script src="<?= base_url('/') ?>/assets/plugins/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?= base_url('/') ?>/assets/plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url('/') ?>/assets/plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url('/') ?>/assets/plugins/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
    <script src="<?= base_url('/') ?>/assets/js/funciones.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.min.js">
    </script>
    <script
        src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.templates.min.js">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <link
        href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.8.2/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
        rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.8.2/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.js">
    </script>


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://www.chartjs.org/dist/2.7.2/Chart.bundle.js"></script>
    <!-- LINKS DATA TABLES -->

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js">
    </script>

    <script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.8.2/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.js">
    </script>
    <link href="<?= base_url('/') ?>/assets/plugins/scrollmaster/dist/jquery.floatingscroll.css" rel="stylesheet" />

    <script src="<?= base_url('/') ?>/assets/plugins/scrollmaster/dist/jquery.floatingscroll.min.js" />
    </script>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="template/plugins/fontawesome-free/css/all.min.css">
	<!-- IonIcons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="template/dist/css/adminlte.min.css">
	<style>
		tfoot input {
			width: 100% !important;
		}

		tfoot {
			display: table-header-group !important;
		}
	</style>
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="<?php echo base_url('/inicio') ?>" class="nav-link">Home</a>
				</li>

			</ul>

			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
				<!-- Navbar Search -->
				<li class="nav-item dropdown">
					<a class="nav-link" data-toggle="dropdown" href="#">
						<?= $imagen =  session('foto') != '' ? '<img src="data:image/png;base64,' .  session('foto') . '"  class="img-responsive" height="30px"/>' : '<img src="assets/img/user/default_user.png" height="30px" />'; ?>

						<span class="badge badge-warning navbar-badge"></span> <?= session('usuario') ?>

					</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right text-center">
						<div class="dropdown-divider"></div>
						<a href="<?php echo base_url('/perfil') ?>" class="dropdown-item">
							<i class="fas fa-user mr-2"></i> PERFIL
						</a>
						<div class="dropdown-divider"></div>
						<a href="<?php echo base_url('/salir') ?>" class="dropdown-item">
							<i class="fas fa-power-off mr-2"></i> SALIR
						</a>

						<div class="dropdown-divider"></div>
					</div>
				</li>

				<!-- Messages Dropdown Menu -->

				<!-- Notifications Dropdown Menu -->
				<!--   <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li> -->
				<li class="nav-item">
					<a class="nav-link" data-widget="fullscreen" href="#" role="button">
						<i class="fas fa-expand-arrows-alt"></i>
					</a>
				</li>

			</ul>
		</nav>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<a href="<?php echo base_url('/inicio') ?>" class="brand-link">
				<img src="template/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
				<span class="brand-text font-weight-light">AdminLTE 3</span>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar user panel (optional) -->




				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
						<!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
						<?php $url_ptr =  explode("/", $_SERVER['REQUEST_URI']);
						$URL = $url_ptr[count($url_ptr) - 1];
						?>
						<li class="nav-item ">
							<a href="<?php echo base_url('/inicio') ?>" class="nav-link <?= $URL == 'inicio' ? 'active' : '' ?>">
								<span class="menu-icon"><i class="fas fa-lg fa-fw me-2 fa-home"></i></span>
								<p class="menu-text">INICIO</p>
							</a>
						</li>


						<!-- CONSULTA PARA EL MENU DEPENDIENDO EL USUARIO   -->
						<?php
						$C_modulos = "Select * from t_modulos where activo = 'si'";
						$sModulos = db_query2($C_modulos);
						while ($rModulos = $sModulos->fetch_array(MYSQLI_BOTH)) {
							$idModulo =  $rModulos['id_modulo'];
							$queryModulos = ("select * 
					FROM t_permisos p
					INNER JOIN t_submodulos sm ON sm.id_submodulo  = p.id_submodulo
					WHERE p.id_usuario = $id_usuario and sm.Modulo = $idModulo and sm.activo = 'si' ");
							$sModulo = db_query2($queryModulos);
							$sModulo2 = db_query2($queryModulos);

							$rowModulos = $sModulo->fetch_array(MYSQLI_BOTH);

							if (isset($rowModulos['Modulo'])) {

						?><li class="nav-item">
									<a href="<?= $rModulos['principal'] == 1 ? $rModulos['archivo'] : '#' ?>" class="nav-link   <?= $URL == $rModulos['archivo'] ? 'active' : '' ?>">
										<i class="<?= $rModulos['icono'] ?>"></i>
										<p>
											<?= $rModulos['modulo'] ?>

											<?= $rModulos['principal'] == 1 ? '' : '<i class="right fas fa-angle-left"></i>' ?>
										</p>
									</a>
									<?php
									if ($rModulos['principal'] == 0) {


										while ($rowSubModulos = $sModulo2->fetch_array(MYSQLI_BOTH)) {
									?>

											<ul class="nav nav-treeview" style="display: none;">
												<li class="nav-item <?= $URL == $rowSubModulos['Submodulo'] ? 'active' : '' ?>">
													<a href="<?php echo base_url('/' . $rowSubModulos['Archivo']) ?>" class="nav-link">
														<i class="<?= $rowSubModulos['Icono'] ?>"></i>
														<p><?= $rowSubModulos['Submodulo'] ?></p>
													</a>
												</li>

											</ul>

									<?php }
									} ?>
								</li>




						<?php }
						} ?>

					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<div class="container-fluid">

				<?= $this->renderSection('content') ?>


			</div>


			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->

		<!-- Main Footer -->
		<footer class="main-footer">
			<strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
			All rights reserved.
			<div class="float-right d-none d-sm-inline-block">
				<b>Version</b> 3.2.0
			</div>
		</footer>
	</div>
	<!-- ./wrapper -->

	<!-- REQUIRED SCRIPTS -->

	<!-- jQuery -->
	<script src="template/plugins/jquery/jquery.min.js"></script>
	<script src="assets/js/funciones.js"></script>

	<!-- Bootstrap -->
	<script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE -->
	<script src="template/dist/js/adminlte.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- OPTIONAL SCRIPTS -->
	<script src="template/plugins/chart.js/Chart.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="template/dist/js/demo.js"></script>
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<script src="template/dist/js/pages/dashboard3.js"></script>
	<script src="assets/plugins/tinymce5.7/tinymce.min.js" referrerpolicy="origin"></script>
	<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">

	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script> -->

	<!-- 	<link href="assets/plugins/DataTablesdatatables.min.css" rel="stylesheet"/>
	<script src="assets/plugins/DataTablesdatatables.min.js"></script> -->
	<link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.13.3/af-2.5.2/b-2.3.5/b-colvis-2.3.5/b-html5-2.3.5/b-print-2.3.5/cr-1.6.1/date-1.3.1/fc-4.2.1/fh-3.3.1/kt-2.8.1/r-2.4.0/rg-1.3.0/rr-1.3.2/sc-2.1.0/sb-1.4.0/sp-2.1.1/sl-1.6.1/sr-1.2.1/datatables.min.css" rel="stylesheet" />
	<script type="text/javascript">
		function example_image_upload_handler(blobInfo, success, failure, progress) {
			var xhr, formData;

			xhr = new XMLHttpRequest();
			xhr.withCredentials = false;
			xhr.open('POST', 'postAcceptor.php');

			xhr.upload.onprogress = function(e) {
				progress(e.loaded / e.total * 100);
			};

			xhr.onload = function() {
				var json;

				if (xhr.status === 403) {
					failure('HTTP Error: ' + xhr.status, {
						remove: true
					});
					return;
				}

				if (xhr.status < 200 || xhr.status >= 300) {
					failure('HTTP Error: ' + xhr.status);
					return;
				}

				json = JSON.parse(xhr.responseText);

				if (!json || typeof json.location != 'string') {
					failure('Invalid JSON: ' + xhr.responseText);
					return;
				}

				success(json.location);
			};

			xhr.onerror = function() {
				failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
			};

			formData = new FormData();
			formData.append('file', blobInfo.blob(), blobInfo.filename());

			xhr.send(formData);
		};
		tinymce.init({
			content_css: "/mycontent.css",
			language: 'es_MX',
			selector: '#editor',
			height: 450,
			fontsize_formats: "5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt",
			fontsize: '6pt',
			file_picker_types: 'file image media',
			menubar: false,
			paste_data_images: true,
			plugins: [
				'print preview anchor ',
				'searchreplace visualblocks  fullscreen charmap', ,
				'   contextmenu   powerpaste link autolink lists  image  table'

			],
			branding: false,
			powerpaste_word_import: 'clean',
			powerpaste_keep_unsupported_src: true,
			powerpaste_html_import: 'clean',
			smart_paste: false,
			/*   images_upload_url: './postAcceptor.php', */
			contextmenu: false,
			toolbar: ' fontselect styleselect fontsizeselect| bold italic |  autolink image table  link  |formatpainter permanentpen forecolor backcolor  | alignleft aligncenter alignright alignjustify | addcomment showcomments| casechange |bullist numlist outdent indent | advcode spellchecker a11ycheck | code | checklist | ',
			toolbar_drawer: 'sliding',
			skin: "RMN2", //Add these two options
			permanentpen_properties: {
				fontname: 'helvetica,sans-serif,arial',
				forecolor: '#FF0000',
				fontsize: '6pt',
				hilitecolor: '',
				bold: true,
				italic: false,
				strikethrough: false,
				underline: false
			},
			font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
			images_upload_handler: example_image_upload_handler,
			table_toolbar: "tableprops cellprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
			powerpaste_allow_local_images: true,
			powerpaste_word_import: 'prompt',
			powerpaste_html_import: 'prompt',
			spellchecker_language: 'es',
			spellchecker_dialog: true,
			browser_spellcheck: true,
			relative_urls: false,
			remove_script_host: false,

			content_css: [
				'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
				'//www.tinymce.com/css/codepen.min.css'
			],
			link_context_toolbar: true
		});

		// Prevent Bootstrap dialog from blocking focusin
		document.addEventListener('focusin', (e) => {
			if (e.target.closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
				e.stopImmediatePropagation();
			}
		});
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.13.3/af-2.5.2/b-2.3.5/b-colvis-2.3.5/b-html5-2.3.5/b-print-2.3.5/cr-1.6.1/date-1.3.1/fc-4.2.1/fh-3.3.1/kt-2.8.1/r-2.4.0/rg-1.3.0/rr-1.3.2/sc-2.1.0/sb-1.4.0/sp-2.1.1/sl-1.6.1/sr-1.2.1/datatables.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#users-list').DataTable();
		});
	</script>
   <script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.min.js">
    </script>
    <script
        src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.templates.min.js">
    </script>
  
</body>

</html>