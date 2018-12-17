
<?php if ($this->session->flashdata('message')) { ?>
	<div class="alert alert-dismissible alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p class="mb-0"><?php echo $this->session->flashdata('message');?></p>
	</div>
<?php } ?>
<h4>Konfirmasi Penghapusan</h4>
<ul>
	<li>Tekan <strong>YA, BERSIHKAN DATA</strong> untuk menghapus semua data dari database dan tidak dapat dikembalikan.</li>
	<li>Tekan <strong>TIDAK, JANGAN BERSIHKAN</strong> untuk membatalkan.</li>
</ul>
<div class="btn-group" role="group" aria-label="Basic example">
	<a href="<?=base_url('p/clean');?>"><button type="button" class="btn btn-danger">YA, BERSIHKAN DATA</button></a> &nbsp; 
	<a href="<?=base_url();?>"><button type="button" class="btn btn-primary">TIDAK, JANGAN BERSIHKAN</button></a>
</div><br /><br />
