<aside class="left-sidebar" data-sidebarbg="skin6">
	<!-- Sidebar scroll-->
	<div class="scroll-sidebar">
		<!-- Sidebar navigation-->
		<nav class="sidebar-nav">
			<ul id="sidebarnav">
				<li class="sidebar-item mt-4">
					<span>MENU</span>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url() ?>dashboard" aria-expanded="false">
						<i class="mdi mdi-view-dashboard"></i>
						<span class="hide-menu">Dashboard</span>
					</a>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url() ?>dashboard/arsip" aria-expanded="false">
						<i class="mdi mdi-archive"></i>
						<span class="hide-menu">Arsip</span>
					</a>
				</li>
				<?php if($this->myrole->is('klasifikasi')) { ?>
					<li class="sidebar-item">
						<a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url() ?>dashboard/kode-klasifikasi" aria-expanded="false">
							<i class="mdi mdi-folder"></i>
							<span class="hide-menu">Kode Klasifikasi</span>
						</a>
					</li>
				<?php } ?>
				<?php if($this->myrole->is('aduan')) { ?>
				<li class="sidebar-item">
					<a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url() ?>dashboard/aduan" aria-expanded="false">
						<i class="mdi mdi-email-alert"></i>
						<span class="hide-menu">Aduan</span>
					</a>
				</li>
				<?php } ?>
				<?php if ($this->myrole->is('admin')){ ?>
				<li class="sidebar-item">
					<a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url() ?>dashboard/pengelola" aria-expanded="false">
						<i class="mdi mdi-account-circle"></i>
						<span class="hide-menu">Pengelola</span>
					</a>
				</li>
				<?php } ?>
				<?php if(false) { ?>
				<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
						href="table-basic.html" aria-expanded="false"><i class="mdi mdi-border-all"></i><span
							class="hide-menu">Table</span></a></li>
				<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
						href="icon-material.html" aria-expanded="false"><i class="mdi mdi-face"></i><span
							class="hide-menu">Icon</span></a></li>
				<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
						href="starter-kit.html" aria-expanded="false"><i class="mdi mdi-file"></i><span
							class="hide-menu">Blank</span></a></li>
				<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
						href="error-404.html" aria-expanded="false"><i class="mdi mdi-alert-outline"></i><span
							class="hide-menu">404</span></a></li>
				<li class="text-center p-40 upgrade-btn">
					<a href="https://www.wrappixel.com/templates/flexy-bootstrap-admin-template/"
						class="btn d-block w-100 btn-danger text-white" target="_blank">Upgrade to Pro</a>
				</li>
				<?php } ?>
			</ul>

		</nav>
		<!-- End Sidebar navigation -->
	</div>
	<!-- End Sidebar scroll-->
</aside>
