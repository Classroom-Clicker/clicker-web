<div id='header'>
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="<?php echo base_url(); ?>">Classroom clicker</a>
			</div>
			<div class="navbar-collapse">
				<?php if(phpCas::isAuthenticated()){ ?>
				<a href="<?php echo base_url()."users/logout"?>" class="navbar-form navbar-right" role="form">
					<button type="submit" class="btn btn-danger">Sign out</button>
				</a>
				<?php } else { ?>
				<a href="<?php echo base_url()."users/login"?>" class="navbar-form navbar-right" role="form">
					<button type="submit" class="btn btn-success">Sign in</button>
				</a>
				<?php } ?>

			</div>
		</div>
	</div>
	<div class="container" style='margin-top:60px'></div>
</div>
