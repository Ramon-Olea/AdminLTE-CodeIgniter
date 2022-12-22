<?= $this->extend('header')  ?>
<!-- SE INCLUYE LA PLANTILLA -->
<?= $this->section('content') ?>



<div class="content-header">
	<h1 class="page-header">
		<?= session('usuario') ?>
	</h1>

</div>
<?= $this->endSection() ?>