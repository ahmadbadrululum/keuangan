
	<br />
	<div class="navbar navbar-expand-lg navbar-dark bg-primary">
		<a class="navbar-brand" href="<?=base_url();?>">Keuangan</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation" style="">
				<span class="navbar-toggler-icon"></span>
		</button>
		<?php if ($this->session->userdata('username')) {?>
		<div class="collapse navbar-collapse" id="navbarColor01">
	  		<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="<?=base_url();?>">Beranda <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?=base_url('p/masuk');?>">Pemasukan</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?=base_url('p/keluar');?>">Pengeluaran</a>
				</li>
			    <li class="nav-item">
	    			<a class="nav-link" href="<?=base_url('p/laporan');?>">Laporan</a>
	    		</li>
		   		<li class="nav-item">
	    			<a class="nav-link" href="<?=base_url('p/bersihkan');?>">Bersihkan Data</a>
	    		</li>
	    		<li class="nav-item">
	    			<a class="nav-link" href="<?=base_url('p/logout');?>">Logout</a>
	    		</li>
	    	</ul>
	    	<form class="form-inline my-2 my-lg-0" action="<?=base_url('p/cari');?>" method="GET">
	    		<input name="s" class="form-control mr-sm-2" type="text" placeholder="Cari disini">
	    		<button class="btn btn-primary my-2 my-sm-0" type="submit">Cari</button>
			</form>
		</div>
		<?php } ?>
	</div>
	<br />
	