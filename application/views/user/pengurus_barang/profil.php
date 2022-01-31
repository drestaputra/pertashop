<!doctype html>
<html class="fixed">
<head>

	<!-- Basic -->
	<meta charset="UTF-8">

	<title>Dashboard Koordinator | <?php echo function_lib::get_config_value('website_name'); ?></title>
	<meta name="keywords" content="Dashboard Koordinator - <?php echo function_lib::get_config_value('website_name'); ?>" />
	<meta name="description" content="<?php echo function_lib::get_config_value('website_seo'); ?>">
	<meta name="author" content="okler.net">

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<!-- Web Fonts  -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.css" />

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

	<!-- Specific Page Vendor CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/morris/morris.css" />

	<!-- Theme CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/stylesheets/theme.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/stylesheets/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/stylesheets/theme-custom.css">

	<!-- Head Libs -->
	<script src="<?php echo base_url(); ?>assets/vendor/modernizr/modernizr.js"></script>
</head>
<body>
	<section class="body">

		<?php function_lib::getHeader(); ?>

		<div class="inner-wrapper">
			<!-- start: sidebar -->
			<?php function_lib::getLeftMenu(); ?>
			<!-- end: sidebar -->

			<section role="main" class="content-body">
				<header class="page-header">
					<h2>Profil</h2>
					
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="<?php echo base_url(); ?>">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Profil</span></li>
						</ol>

						<a class="sidebar-right-toggle" ><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>

				<div class="">

					<div class="tabs">
						<ul class="nav nav-tabs tabs-primary">
							<li class="active">
								<a href="#profil" data-toggle="tab">Profil</a>
							</li>
							<li>
								<a href="#password" data-toggle="tab">Password</a>
							</li>
						</ul>
						<div class="tab-content">

							<div id="profil" class="tab-pane  active">

								<form class="form-horizontal" method="post">
									<h4 class="mb-xlg">Personal Information</h4>

									<fieldset>
										<?php if (trim($this->input->get('status'))!=""): ?>
								<?php echo function_lib::response_notif($this->input->get('status'),$this->input->get('msg')); ?>
							<?php endif ?> 
										<div class="form-group">
											<label class="col-md-3 control-label" for="profileFirstName">Username</label>
											<div class="col-md-8">
												<input type="text" name="username_pengurus_barang" class="form-control" value="<?php echo ($this->input->post('username_pengurus_barang')!="")?$this->input->post('username_pengurus_barang'):$profil['username_pengurus_barang']; ?>">
											</div>
										</div>										
										<div class="form-group">
											<label class="col-md-3 control-label" for="profileAddress">Email</label>
											<div class="col-md-8">
												<input type="email_pengurus_barang" class="form-control"  name="email_pengurus_barang" value="<?php echo ($this->input->post('email_pengurus_barang')!="")?$this->input->post('email_pengurus_barang'):$profil['email_pengurus_barang']; ?>">
											</div>
										</div>										
									</fieldset>	
									<div class="panel-footer">
										<div class="row">
											<div class="col-md-9 col-md-offset-3">
												<button type="submit" name="edit" value="1" class="btn btn-primary">Edit</button>
												<a href="<?php echo base_url('admin/dashboard'); ?>" class="btn btn-default">Cancel</a>
											</div>
										</div>
									</div>										


								</form>
							</div>
							<div id="password" class="tab-pane">
								 <form method="POST" id="change_password">
				                    <h4 class="mb-xlg">Ubah Password</h4>                    
				                    <fieldset class="mb-xl">
				                    	<div class="form-group">
				                            <label class="col-md-2 control-label" for="profileNewPassword">Password Saat Ini</label>
				                            <div class="col-md-3">
				                                <input type="password" class="form-control" name="old_password">
				                            </div>
				                        </div>
				                        <div class="form-group">
				                            <label class="col-md-2 control-label" for="profileNewPassword">Password Baru</label>
				                            <div class="col-md-3">
				                                <input type="password" class="form-control" name="new_password">
				                            </div>
				                        </div>
				                        <div class="form-group">
				                            <label class="col-md-2 control-label" for="profileNewPasswordRepeat">Ulangi Password</label>
				                            <div class="col-md-3">
				                                <input type="password" class="form-control" name="repeat_password">
				                            </div>
				                        </div>
				                    </fieldset>
				                    <div class="panel-footer">
				                        <div class="row">
				                            <div class="col-md-9 col-md-offset-3">
				                                <button type="submit" class="btn btn-primary" name="change_password" value="1">Simpan</button>
				                                <a href="<?php echo base_url('admin'); ?>" class="btn btn-default">Cancel</a>
				                            </div>
				                        </div>
				                    </div>
				                </form>   										




							</div>
						</div>
					</div>
				</div>
				<!-- end: page -->
			</section>
		</div>

		<?php $this->load->view('admin/right_bar'); ?>
	</section>

	<!-- Vendor -->
	<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/nanoscroller/nanoscroller.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/magnific-popup/magnific-popup.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>



	<!-- Theme Base, Components and Settings -->
	<script src="<?php echo base_url(); ?>assets/javascripts/theme.js"></script>

	<!-- Theme Custom -->
	<script src="<?php echo base_url(); ?>assets/javascripts/theme.custom.js"></script>

	<!-- Theme Initialization Files -->
	<script src="<?php echo base_url(); ?>assets/javascripts/theme.init.js"></script>

</body>
</html>