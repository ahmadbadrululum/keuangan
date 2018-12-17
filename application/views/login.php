
<h4>Login Administrator</h4>

	<?php if ($this->session->flashdata('message')) { ?>
		<div class="alert alert-dismissible alert-danger">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<p class="mb-0"><?php echo $this->session->flashdata('message');?></p>
		</div>
	<?php } ?>

<form action="<?=base_url('p/login');?>" method="POST">
	<div class="form-group">
		<label class="col-form-label" for="username">Username</label>
		<input type="text" class="form-control" name="username" placeholder="Username" id="username" required="">
	</div>
	<div class="form-group">
		<label class="col-form-label" for="password">Password</label>
		<input type="password" class="form-control" name="password" placeholder="password" id="password" required="">
	</div>
	<button type="submit" class="btn btn-primary">Login</button>
</form>
<br />