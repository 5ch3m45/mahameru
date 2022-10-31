<!DOCTYPE html>
<html dir="ltr" lang="en">

<?php include_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'html_head.php'); ?>

<body>
    <?php include_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'preloader.php'); ?>
    <div 
        id="main-wrapper" 
        data-layout="vertical" 
        data-navbarbg="skin5" 
        data-sidebartype="full"
        data-sidebar-position="absolute" 
        data-header-position="absolute" 
        data-boxed-layout="full">
        <?php include_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'top_bar.php'); ?>
        <?php include_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'left_sidebar.php'); ?>
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-6">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 d-flex align-items-center">
                              <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                              <li class="breadcrumb-item active" aria-current="page">Profil Anda</li>
                            </ol>
                          </nav>
                        <h1 class="mb-0 fw-bold">Profil Anda</h1> 
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <!-- column -->
                    <div class="col-12 col-lg-6">
                        <div class="card mb-5">
                            <form id="form-profile" class="card-body">
                                <h3>Profil</h3>
                                <hr>
                                <div class="mb-4">
                                    <label for="">Nama</label>
                                    <input type="text" class="form-control" name="name">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-4">
                                    <label for="">Email</label>
                                    <input type="text" class="form-control" name="email" disabled style="cursor: not-allowed">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                        <div class="card mb-5">
                            <form id="form-keamanan" class="card-body">
                                <h3>Keamanan</h3>
                                <hr>
                                <div class="mb-4">
                                    <label for="">Buat kata sandi baru</label>
                                    <input type="text" class="form-control" name="new_password">
                                    <span id="error_new_password" class="text-danger"></span>
                                </div>
                                <div class="mb-4">
                                    <label for="">Konfirmasi kata sandi baru</label>
                                    <input type="text" class="form-control" name="new_password_confirm">
                                    <span id="error_new_password_confirm" class="text-danger"></span>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="kodeBaruModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="kodeBaruModalLabel" aria-hidden="true">
    	<div class="modal-dialog modal-dialog-centered">
    		<div class="modal-content">
                <div class="modal-header">
    				<h5 class="modal-title" id="kodeBaruModalLabel">Kode Klasifikasi Baru</h5>
    				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    			</div>
    			<div class="modal-body">
                    <div class="mb-3">
                        <label for="">Kode<span class="text-danger">*</span></label>
                        <input id="kodeInput" required type="text" class="form-control" placeholder="Kode">
                        <div id="kodeError" class="error-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="">Nama<span class="text-danger">*</span></label>
                        <input id="namaInput" required type="text" class="form-control" placeholder="Nama">
                        <div id="namaError" class="error-text"></div>
                    </div>
    				<div class="mb-3">
                        <label for="">Keterangan</label>
                        <textarea id="deskripsiTextarea" class="form-control" rows="3" placeholder="Keterangan (optional)"></textarea>
                        <div id="deskripsiError" class="error-text"></div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                        <button id="submitKodeBtn" type="button" class="btn btn-primary">Simpan</button>
                    </div>
    			</div>
    		</div>
    	</div>
    </div>
    <?php include_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'base_js.php'); ?>
    <script src="<?= assets_url() ?>js/pages/admin/profile/index.js?v=<?= time() ?>"></script>
</body>

</html>