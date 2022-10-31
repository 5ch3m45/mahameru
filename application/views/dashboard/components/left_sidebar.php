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
						<i class="bi bi-diagram-3-fill"></i>
						<span class="hide-menu">Pengelola</span>
					</a>
				</li>
				<?php } ?>
				<li class="sidebar-item">
					<a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url() ?>dashboard/profile" aria-expanded="false">
						<i class="mdi mdi-account"></i>
						<span class="hide-menu">Profile Anda</span>
					</a>
				</li>
				<li class="sidebar-item mt-4">
					<a class="sidebar-link bg-danger text-white waves-effect waves-dark sidebar-link" href="<?= base_url() ?>dashboard/profile" aria-expanded="false">
						<i class="bi bi-power"></i>
						<span class="hide-menu">Keluar</span>
					</a>
				</li>
			</ul>

		</nav>
		<!-- End Sidebar navigation -->
	</div>
	<!-- End Sidebar scroll-->
</aside>
