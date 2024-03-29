<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Admin</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="Dashboard Admin - ArtaKita" />	
	<meta name="author" content="Dresta Twas AP">

	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate/animate.css" />

	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendor/select2/select2.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/stylesheets/login.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/stylesheets/theme-custom.css">
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				
							
				<div class="login100-pic js-tilt" data-tilt>
					<img src="<?php echo base_url('assets/images/login.png'); ?>" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="post">
					 <?php if (trim($this->input->get('status'))!=""): ?>
								<?php echo function_lib::response_notif($this->input->get('status'),$this->input->get('msg')); ?>
							<?php endif ?> 
					<span class="login100-form-title">
						User Login
					</span>					

					<div class="wrap-input100">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100">
						<input class="input100" type="password" name="pwd" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txta">
							Forgot
						</span>
						<a class="txtb" href="#">
							Username / Password?
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
	<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/select2/select2.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>	

</body>
</html>