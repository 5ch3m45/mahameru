<header class="topbar" data-navbarbg="skin6">
	<nav class="navbar top-navbar navbar-expand-md navbar-light">
		<div class="navbar-header" data-logobg="skin6">
			<!-- ============================================================== -->
			<!-- Logo -->
			<!-- ============================================================== -->
			<a class="navbar-brand" href="/">
				<!-- Logo icon -->
				<b class="logo-icon me-1 mt-2">
					<!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
					<!-- Dark Logo icon -->
					<img src="<?= assets_url() ?>images/logo.png" alt="homepage" class="dark-logo" style="height: 64px" />
					<!-- Light Logo icon -->
					<img src="<?= assets_url() ?>images/logo.png" alt="homepage" class="light-logo" />
				</b>
				<!--End Logo icon -->
				<!-- Logo text -->
				<span class="logo-text">
					<div class="my-auto">
						<p class="mb-0" style="line-height: 1.2; font-size: 1.3rem"><strong>MAHAMERU</strong></p>
						<p style="margin: 0; line-height: 1; font-size: .8rem; white-space: pre-wrap;">Manajemen Arsip Hasil Alih Media Baru</p>
					</div>
					<!-- dark Logo text -->
					<!-- <img src="<?= assets_url() ?>images/logo-text.png" alt="homepage" class="dark-logo" /> -->
					<!-- Light Logo text -->
					<!-- <img src="<?= assets_url() ?>images/logo-light-text.png" class="light-logo" alt="homepage" /> -->
				</span>
			</a>
			<!-- ============================================================== -->
			<!-- End Logo -->
			<!-- ============================================================== -->
			<!-- This is for the sidebar toggle which is visible on mobile only -->
			<a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
					class="mdi mdi-menu"></i></a>
		</div>
		<!-- ============================================================== -->
		<!-- End Logo -->
		<!-- ============================================================== -->
		<div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
			<!-- ============================================================== -->
			<!-- toggle and nav items -->
			<!-- ============================================================== -->
			<ul class="navbar-nav float-start me-auto">
				<!-- ============================================================== -->
				<!-- Search -->
				<!-- ============================================================== -->
				<li class="nav-item search-box"> <a class="nav-link waves-effect waves-dark"
						href="javascript:void(0)"><i class="mdi mdi-magnify me-1"></i> <span
							class="font-16">Search</span></a>
					<form class="app-search position-absolute">
						<input type="text" class="form-control" placeholder="Search &amp; enter"> <a class="srh-btn"><i
								class="mdi mdi-window-close"></i></a>
					</form>
				</li>
			</ul>
			<!-- ============================================================== -->
			<!-- Right side toggle and nav items -->
			<!-- ============================================================== -->
			<ul class="navbar-nav float-end">
				<!-- ============================================================== -->
				<!-- User profile and search -->
				<!-- ============================================================== -->
				<li id="profile-menu-container" class="nav-item dropdown">
					{profile_menu}
				</li>
				<!-- ============================================================== -->
				<!-- User profile and search -->
				<!-- ============================================================== -->
			</ul>
		</div>
	</nav>
</header>
