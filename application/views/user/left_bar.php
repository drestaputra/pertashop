<?php $cont=$this->uri->segment(2, 0); ?>
<?php $url1=$this->uri->segment(1, 0); ?>
<aside id="sidebar-left" class="sidebar-left">
				
					<div class="sidebar-header">
						<div class="sidebar-title">
							Navigation
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>
				
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul class="nav nav-main">
									<li <?php if (isset($cont) AND trim($cont)!="" AND $cont=="dashboard"): ?>
										 class="nav-active"
									<?php endif ?>>
										<a href="<?php echo base_url('kasir/dashboard'); ?>">
											<i class="fa fa-home" aria-hidden="true"></i>
											<span>Dashboard</span>
										</a>
									</li>
									<li class="nav-parent <?php if (!empty($url1) AND (trim($url1) == 'master')): ?>nav-expanded nav-active<?php endif ?>">
										<a>
											<i class="fa fa-users" aria-hidden="true"></i>
											<span>Master</span>
										</a>
										<ul class="nav nav-children">
											<li <?php if (isset($cont) AND trim($cont)!="" AND $cont=="bentuk_lahan"): ?>
												 class="nav-active"
											<?php endif ?>>
												<a href="<?php echo base_url('master/bentuk_lahan/index'); ?>">
													<i class="fa fa-users" aria-hidden="true"></i>
													<span>Bentuk Lahan</span>
												</a>
											</li>
											<li <?php if (isset($cont) AND trim($cont)!="" AND $cont=="jenis_kawasan"): ?>
												 class="nav-active"
											<?php endif ?>>
												<a href="<?php echo base_url('master/jenis_kawasan/index'); ?>">
													<i class="fa fa-users" aria-hidden="true"></i>
													<span>Jenis Kawasan</span>
												</a>
											</li>
											<li <?php if (isset($cont) AND trim($cont)!="" AND $cont=="mor"): ?>
										 	class="nav-active"
											<?php endif ?>>
												<a href="<?php echo base_url('master/mor/index'); ?>">
													<i class="fa fa-users" aria-hidden="true"></i>
													<span>MOR</span>
												</a>
											</li>
											
											
										</ul>
									</li>
								

								</ul>
							</nav>
				
							<hr class="separator" />
				
							
				
							<hr class="separator" />
				
							
						</div>
				
					</div>
				
				</aside>