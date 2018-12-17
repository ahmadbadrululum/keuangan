
<h4>Laporan</h4>
<ul class="nav nav-tabs">
	<li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#harian">Harian</a></li>
	<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#periode">Periode</a></li>
</ul>

<div id="myTabContent" class="tab-content">
	<div class="tab-pane fade active show" id="harian"><br />
		<form action="<?=base_url('p/laporan_harian');?>" method="POST">
			<div class="form-group">
				<input name="tanggal" id="datepicker" placeholder="Tanggal" readonly="" required=""><script>$('#datepicker').datepicker({format: 'yyyy/mm/dd', showOtherMonths:true});</script>
			</div>
			<button type="submit" class="btn btn-primary">Lihat Laporan</button>
		</form><br />
	</div>
	<div class="tab-pane fade" id="periode"><br />
		<form action="<?=base_url('p/laporan_periode');?>" method="POST">
    		<div class="form-group">
        		<input name="tgl_mulai" id="startDate" placeholder="Mulai tanggal" readonly="" required="">
        		<input name="tgl_sampai" id="endDate" placeholder="Sampai tanggal" readonly="" required="">
    		</div>
    		<script>
		        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
		        $('#startDate').datepicker({
		            format: 'yyyy/mm/dd',
		            maxDate: function () {
		                return $('#endDate').val();
		            }
		        });
		        $('#endDate').datepicker({
		            format: 'yyyy/mm/dd',
		            minDate: function () {
		                return $('#startDate').val();
		            }
		        });
    		</script>
    		<button type="submit" class="btn btn-primary">Lihat Laporan</button>
    	</form><br />
	</div>
</div>
