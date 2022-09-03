<!DOCTYPE html>
<html dir="ltr" lang="en">

<?php include_once(__DIR__.'/components/html_head.php'); ?>

<body>
    <?php include_once(__DIR__.'/components/preloader.php'); ?>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
    	data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
    	<?php include_once(__DIR__.'/components/top_bar.php'); ?>
    	<?php include_once(__DIR__.'/components/left_sidebar.php'); ?>
    	<div class="page-wrapper">
    		<div class="page-breadcrumb">
    			<div class="row align-items-center">
    				<div class="col-6">
    					<nav aria-label="breadcrumb">
    						<ol class="breadcrumb mb-0 d-flex align-items-center">
    							<li class="breadcrumb-item"><a href="<?= base_url() ?>" class="link"><i
    										class="mdi mdi-home-outline fs-4"></i></a></li>
    							<li class="breadcrumb-item"><a href="<?= base_url('admin/pengelola') ?>"
    									class="link">Pengelola</a></li>
    							<li id="admin-nama-breadcrumb" class="breadcrumb-item active" aria-current="page">
    								{nama_pengelola}</li>
    						</ol>
    					</nav>
    				</div>
    				<div class="col-6">
    					<div class="text-end upgrade-btn">
    						<a href="<?= base_url('admin/pengelola') ?>" class="btn btn-primary text-white">
    							<i class="mdi mdi-arrow-left"></i>
    							Kembali
    						</a>
    					</div>
    				</div>
    			</div>
    		</div>
    		<div class="container-fluid">
    			<div class="row d-flex align-items-stretch">
    				<div class="col-lg-4 col-xl-3 col-md-5">
    					<div class="card">
    						<div class="card-body">
    							<div class="text-center mb-4">
    								<img src="http://mahameru.test/assets/images/users/5.jpg" alt="user" width="100"
    									class="rounded-circle">
    								<h1 id="admin-nama-title" class="mb-0 fw-bold me-2">{nama_pengelola}</h1>
    							</div>

    							<small class="text-muted p-t-30 db">Email</small>
    							<h6 id="admin-email">{email_pengelola}</h6>
    							<small class="text-muted p-t-30 db">Arsip Dikelola</small>
    							<h6 id="admin-arsip-count">{jumlah_arsip_dikelola}</h6>
    							<small class="text-muted p-t-30 db">Terakhir login</small>
    							<h6 id="admin-last-login">{terakhir_login_pengelola}</h6>
    						</div>
    					</div>
    				</div>
    				<div class="col-lg-8 col-xlg-9 col-md-7">
    					<div class="card mb-0">
    						<div class="card-body">
    							{aktivitas_pengelola}
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    	<div class="modal fade" id="lampiranDetailModal" data-bs-backdrop="static" data-bs-keyboard="false"
    		tabindex="-1" aria-labelledby="lampiranDetailModalLabel" aria-hidden="true">
    		<div class="modal-dialog modal-dialog-centered d-flex justify-content-center">
    			<div class="modal-content" style="width: auto">
    				<div id="lampiranFile"></div>
    				<div class="modal-body">
    					<div class="d-flex justify-content-end">
    						<button id="hapusLampiranBtn" data-id="" type="button"
    							class="btn btn-danger text-white me-2">Hapus</button>
    						<button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <?php include_once(__DIR__.'/components/base_js.php'); ?>
    <script src="<?= assets_url() ?>js/pages/admin/pengelola/detail.js?v=<?= time() ?>"></script>
</body>

</html>