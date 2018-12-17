
<?php if ($this->session->flashdata('message')) { ?>
	<div class="alert alert-dismissible alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p class="mb-0"><?php echo $this->session->flashdata('message');?></p>
	</div>
<?php } ?>
<h4>Selamat Datang, <strong><?=$this->session->userdata('name');?></strong></h4>
<p><strong>KasApp</strong> adalah aplikasi berbasis web sederhana yang dapat digunakan untuk mengontrol keuangan dengan mudah.</p>
