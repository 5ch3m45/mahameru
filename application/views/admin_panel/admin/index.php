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
                              <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                              <li class="breadcrumb-item active" aria-current="page">Pengelola</li>
                            </ol>
                          </nav>
                        <h1 class="mb-0 fw-bold">Pengelola</h1> 
                    </div>
                    <div class="col-6">
                        <div class="text-end upgrade-btn">
                            <button id="pengelolaBaruBtn" class="btn btn-primary text-white">
                                Tambah Baru
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <!-- column -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- title -->
                                <div class="table-responsive" style="min-height: 30rem">
                                    <table id="admin-table" class="table mb-4 table-hover align-middle text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Nama</th>
                                                <th class="border-top-0">Email</th>
                                                <th class="border-top-0">Arsip Dikelola</th>
                                                <th class="border-top-0">Status</th>
                                                <th class="border-top-0">Terakhir Login</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr><td colspan="5" class="text-center"><image src="/assets/images/loader/loading.svg"/></td></tr>
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" id="prev-table" class="btn btn-primary me-2">Sebelumnya</button>
                                        <button type="button" id="next-table" class="btn btn-primary">Selanjutnya</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade rounded-corner" id="pengelolaBaruModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="pengelolaBaruModalLabel" aria-hidden="true">
    	<div class="modal-dialog modal-dialog-centered">
    		<div class="modal-content rounded-corner">
                <div class="modal-header rounded-corner">
    				<h5 class="modal-title" id="pengelolaBaruModalLabel">Tambah Pengelola Baru</h5>
    				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    			</div>
    			<form id="pengelola-baru-form" action="/api/dashboard/admin/baru" method="post" class="modal-body rounded-corner">
                    <div class="mb-3">
                        <label for="">Nama</label>
                        <input id="nama-input" type="text" class="form-control">
                        <div id="namaError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="">Email</label>
                        <input id="email-input" type="email" class="form-control">
                        <div id="emailError"></div>
                    </div>
                    <hr class="my-3">
                    <div class="mb-3">
                        <label for=""><strong>Otoritas Pengelola</strong></label>
                        <br>
                        <small><strong>Pengelola</strong></small>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="otoritas-pengelola">
                            <label class="form-check-label" for="otoritas-pengelola">
                                Mengelola Pengelola
                            </label>
                        </div>
                        <small><strong>Arsip</strong></small>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="otoritas_arsip" id="otoritas-arsip-publik" checked>
                            <label class="form-check-label" for="otoritas-arsip-publik">
                                Mengelola hanya arsip publik
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="otoritas_arsip" id="otoritas-arsip-rahasia" >
                            <label class="form-check-label" for="otoritas-arsip-rahasia">
                                Mengelola semua arsip (publik dan rahasia)
                            </label>
                        </div>
                        <small><strong>Klasifikasi</strong></small>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="otoritas-klasifikasi">
                            <label class="form-check-label" for="otoritas-klasifikasi">
                                Mengelola klasifikasi
                            </label>
                        </div>
                        <small><strong>Aduan</strong></small>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="otoritas-aduan">
                            <label class="form-check-label" for="otoritas-aduan">
                                Mengelola aduan
                            </label>
                        </div>
                        <div id="emailError"></div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                        <button id="submitKodeBtn" type="submit" class="btn btn-primary">Simpan</button>
                    </div>
    			</form>
    		</div>
    	</div>
    </div>
    <?php include_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'base_js.php'); ?>
    <script src="<?= assets_url() ?>js/pages/admin/pengelola/index.js?v=<?= time() ?>"></script>
</body>

</html>