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
                              <li class="breadcrumb-item active" aria-current="page">Kode Klasifikasi</li>
                            </ol>
                          </nav>
                        <h1 class="mb-0 fw-bold">Kode Klasifikasi</h1> 
                    </div>
                    <div class="col-6">
                        <div class="text-end upgrade-btn">
                            <button id="kodeBaruBtn" class="btn btn-primary text-white">
                                Buat Baru
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
                                <div class="row mb-4">
                                    <div class="col-12 col-md-3">
                                        <label for="search-table">Cari</label>
                                        <input type="text" name="search" id="search-table" class="form-control" placeholder="Cari">
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label for="search-table">Urutkan</label>
                                        <select name="sort" id="sort-table" class="form-control">
                                            <option value="kode">Kode</option>
                                            <option value="nama">Nama</option>
                                            <option value="arsip-terbanyak">Arsip Terbanyak</option>
                                            <option value="arsip-tersedikit">Arsip Tersedikit</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="table-responsive" style="min-height: 30rem">
                                    <table id="klasifikasi-table" class="table mb-0 table-hover align-middle text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Nama</th>
                                                <th class="border-top-0">Jumlah Arsip</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr><td colspan="2" class="text-center"><image src="/assets/images/loader/loading.svg"/></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
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
    <script src="<?= assets_url() ?>js/pages/admin/klasifikasi/index.js?v=<?= time() ?>"></script>
</body>

</html>