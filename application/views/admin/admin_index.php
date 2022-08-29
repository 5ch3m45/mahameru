<!DOCTYPE html>
<html dir="ltr" lang="en">

<?php include_once(__DIR__.'/components/html_head.php'); ?>

<body>
    <?php include_once(__DIR__.'/components/preloader.php'); ?>
    <div 
        id="main-wrapper" 
        data-layout="vertical" 
        data-navbarbg="skin5" 
        data-sidebartype="full"
        data-sidebar-position="absolute" 
        data-header-position="absolute" 
        data-boxed-layout="full">
        <?php include_once(__DIR__.'/components/top_bar.php'); ?>
        <?php include_once(__DIR__.'/components/left_sidebar.php'); ?>
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-6">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 d-flex align-items-center">
                              <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                              <li class="breadcrumb-item active" aria-current="page">Pengelola</li>
                            </ol>
                          </nav>
                        <h1 class="mb-0 fw-bold">Pengelola</h1> 
                    </div>
                    <div class="col-6">
                        <div class="text-end upgrade-btn">
                            <button id="kodeBaruBtn" class="btn btn-primary text-white">
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
                                                <th class="border-top-0">Jumlah Arsip Dikelola</th>
                                                <th class="border-top-0">Terakhir Login</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
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
            <footer class="footer text-center">
                All Rights Reserved by Flexy Admin. Designed and Developed by <a
                    href="https://www.wrappixel.com">WrapPixel</a>.
            </footer>
        </div>
    </div>
    <div class="modal fade" id="pengelolaBaruModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="pengelolaBaruModalLabel" aria-hidden="true">
    	<div class="modal-dialog modal-dialog-centered">
    		<div class="modal-content">
                <div class="modal-header">
    				<h5 class="modal-title" id="pengelolaBaruModalLabel">Tambah Pengelola Baru</h5>
    				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    			</div>
    			<div class="modal-body">
                    <div class="mb-3">
                        <label for="">Nama</label>
                        <input id="namaInput" type="text" class="form-control">
                        <div id="namaError" class="error-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="">Email</label>
                        <input id="emailInput" type="email" class="form-control">
                        <div id="emailError" class="error-text"></div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                        <button id="submitKodeBtn" type="button" class="btn btn-primary">Simpan</button>
                    </div>
    			</div>
    		</div>
    	</div>
    </div>
    <?php include_once(__DIR__.'/components/base_js.php'); ?>
    <script src="<?= assets_url() ?>js/pages/admin/pengelola/index.js?v=<?= time() ?>"></script>
</body>

</html>