
	<?php if (empty($tanggal) && empty($result)) { ?>
		<div class="alert alert-dismissible alert-warning">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<p class="mb-0">Tanggal harian belum ditentukan</p>
		</div>
		<p><a href="<?=base_url('p/laporan');?>"><button type="button" class="btn btn-primary">Kembali ke Laporan</button></a></p>
	<?php } else if (!empty($tanggal) && empty($result)) { ?>
		<p><a href="<?=base_url('p/laporan');?>"><button type="button" class="btn btn-primary">Kembali ke Laporan</button></a></p>
		<h4>Laporan Harian</h4>
		<p>Tanggal <strong><?=$tanggal;?></strong></p>
		<table class="table table-hover">
			<thead>
				<tr>
					<th scope="col">Nomor</th>
					<th scope="col">Keterangan</th>
					<th scope="col">Tanggal</th>
					<th scope="col">Jumlah</th>
					<th scope="col">Jenis</th>
					<th scope="col">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="6" align="center">Tidak ada data</td>
				</tr>
			</tbody>
		</table>
	<?php } else if (!empty($tanggal) && !empty($result)) { ?>
		<p><a href="<?=base_url('p/laporan');?>"><button type="button" class="btn btn-primary">Kembali ke Laporan</button></a></p>
		<h4>Laporan Harian</h4>
		<p>Tanggal <strong><?=date('d/m/Y', strtotime($tanggal));?></strong></p>
		<table class="table table-hover">
			<thead>
				<tr>
					<th scope="col">Nomor</th>
					<th scope="col">Keterangan</th>
					<th scope="col">Tanggal</th>
					<th scope="col">Jumlah</th>
					<th scope="col">Jenis</th>
					<th scope="col">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($result as $data) { ?>
				<tr>
					<td><?=$data->nomor;?></td>
					<td><?=$data->keterangan;?></td>
					<td><?=date('d/m/Y', strtotime($data->tanggal));?></td>
					<td>Rp <?=number_format($data->jumlah,2,',','.');?></td>
					<td><?=ucwords($data->jenis);?></td>
					<?php
					if ($data->jenis == 'masuk'){
						$uri = 'pemasukan';
					}else{
						$uri = 'pengeluaran';
					}
					?>
					<td>
						<a href="<?=base_url('p/ubah_'.$uri.'/'.$data->nomor);?>"><span class="badge badge-pill badge-primary">Ubah</span></a> &nbsp; 
						<a href="<?=base_url('p/hapus_'.$uri.'/'.$data->nomor);?>"><span class="badge badge-pill badge-danger">Hapus</span></a>
					</td>
				</tr>
			<?php } ?>
			</tbody>
			<thead>
			<?php
				error_reporting(0);
				foreach ($ttl_masuk as $total_masuk) {
					$jumlah_masuk += $total_masuk->jumlah;
				}
				foreach ($ttl_keluar as $total_keluar) {
					$jumlah_keluar += $total_keluar->jumlah;
				}
				$jumlah = $jumlah_masuk-$jumlah_keluar;
			?>
				<tr>
					<th colspan="3" scope="col">TOTAL <small>(Pemasukan dan Pengeluaran Tanggal <?=date('d/m/Y', strtotime($data->tanggal));?>)</small></th>
					<th scope="col">Rp. <?=number_format($jumlah,2,',','.');?></th>
					<th colspan="2" scope="col">&nbsp;</th>
				</tr>
			</thead>
		</table>
	<?php 
		echo $halaman; 
	} 
	?>
