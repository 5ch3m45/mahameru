<!DOCTYPE html>
<html dir="ltr" lang="en">

<?php include_once(__DIR__.'/components/html_head.php'); ?>

<body>
    <?php include_once(__DIR__.'/components/preloader.php'); ?>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
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
                              <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                              <li class="breadcrumb-item"><a href="<?= base_url('admin/arsip') ?>" class="link">Arsip</a></li>
                              <li id="nomor-arsip-breadcrumb" class="breadcrumb-item active" aria-current="page">{nomor_arsip}</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-6">
                        <div class="text-end upgrade-btn">
                            <a href="<?= base_url('admin/arsip') ?>" class="btn btn-primary text-white">
                                <i class="mdi mdi-arrow-left"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="d-flex">
                    <h1 id="nomor-arsip-title" class="mb-0 fw-bold me-2">{nomor_arsip}</h1>
                    <span id="is-draft-flag" style="display: none" class="badge bg-warning ms-1 my-auto py-auto">Draft</span>
                </div>
                <hr>            
                <div class="d-flex justify-content-between">
                    <div>
                        <button id="ubahInformasiBtn" class="btn btn-text text-primary me-2 mb-2 mb-md-0">Ubah informasi</button>
                        <button id="uploadNewImageBtn" class="btn btn-text text-primary mb-2 mb-md-0">Upload lampiran</button>
                    </div>
                    <div>
                        <button id="publikasiBtn" style="display: none" class="btn btn-primary me-2 mb-2 mb-md-0">Publikasi</button>
                        <button id="draftBtn" style="display: none" class="btn btn-primary me-2 mb-2 mb-md-0">Simpan sebagai draft</button>
                        <button id="delete-btn" class="btn btn-danger text-white mb-2 mb-md-0 me-2">Hapus</button>
                    </div>
                </div>
                <hr>
                <!-- Row -->
                <div class="row d-flex align-items-stretch">
                    <!-- Column -->
                    <div class="col-12">
                        <div class="card rounded-corner">
                            <div class="card-body">
                                <p id="informasi-text">{informasi_arsip}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <small class="text-muted">Nomor</small>
                                <h6 id="nomor-arsip-text">{nomor_arsip}</h6>
                                <small class="text-muted p-t-30 db">Kode klasifikasi</small>
                                <h6 id="klasifikasi-arsip-text">{klasifikasi_arsip}</h6>
                                <small class="text-muted p-t-30 db">Pencipta</small>
                                <h6 id="pencipta-arsip-text">{pencipta_arsip}</h6>
                                <small class="text-muted p-t-30 db">Tahun Arsip</small>
                                <h6 id="tahun-arsip-text">{tahun_arsip}</h6>
                                <small class="text-muted p-t-30 db">Terakhir diupdate</small>
                                <h6 id="last-updated-text">{last_update_arsip}</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card mb-0">
                            <div class="card-body">
                            	<div class="my-masonry-grid">{lampiran_arsip}</div>
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
    <div class="modal fade" id="lampiranDetailModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="lampiranDetailModalLabel" aria-hidden="true">
    	<div class="modal-dialog modal-dialog-centered d-flex justify-content-center">
    		<div class="modal-content" style="width: auto">
                <div id="lampiranFile"></div>
    			<div class="modal-body">
                    <div class="d-flex justify-content-end">
                        <button id="hapusLampiranBtn" data-id="" type="button" class="btn btn-danger text-white me-2">Hapus</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    </div>
    			</div>
    		</div>
    	</div>
    </div>
    <div class="modal fade" id="hapusLampiranConfirmModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="hapusLampiranConfirmModalLabel" aria-hidden="true">
    	<div class="modal-dialog modal-dialog-centered">
    		<div class="modal-content">
                <div class="modal-header">
    				<h5 class="modal-title" id="uploadNewImageModalLabel">Hapus Lampiran</h5>
    				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    			</div>
    			<div class="modal-body">
                    <p>Anda akan menghapus lampiran ini. Yakin?</p>
                    <div class="d-flex justify-content-end">
                        <button id="hapusLampiranSubmit" type="button" class="btn btn-danger text-white me-2" data-id="">Hapus</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    </div>
    			</div>
    		</div>
    	</div>
    </div>
    <div class="modal fade" id="ubahInformasiModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="ubahInformasiModalLabel" aria-hidden="true">
    	<div class="modal-dialog modal-dialog-centered">
    		<div class="modal-content">
                <div class="modal-header">
    				<h5 class="modal-title" id="editArsipModalLabel">Ubah Informasi</h5>
    				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    			</div>
    			<div class="modal-body">
                    <div class="mb-3">
                        <label for="">Nomor</label>
                        <input id="nomorInput" type="text" class="form-control" value="">
                        <div id="nomorError" class="error-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="">Tahun</label>
                        <input id="tahunInput" type="text" class="form-control" value="">
                        <div id="tahunError" class="error-text"></div>
                    </div>
    				<div class="mb-3">
                        <label for="">Kode Klasifikasi</label>
                        <select id="klasifikasiSelect" name="klasifikasi" class="form-select"></select>
                        <div id="klasifikasiError" class="error-text"></div>
                    </div>
    				<div class="mb-3">
                        <label for="">Pencipta</label>
                        <input type="text" name="" class="form-control" id="penciptaInput" value="">
                        <div id="penciptaError" class="error-text"></div>
                    </div>
    				<div class="mb-3">
                        <label for="">Uraian Informasi</label>
                        <textarea id="informasiTextarea" name="" id="" rows="2" class="form-control"></textarea>
                        <div id="informasiError" class="error-text"></div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                        <button id="submitArsipBtn" type="button" class="btn btn-primary">Simpan</button>
                    </div>
    			</div>
    		</div>
    	</div>
    </div>
    <div class="modal fade" id="uploadNewImageModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="uploadNewImageModalLabel" aria-hidden="true">
    	<div class="modal-dialog modal-dialog-centered">
    		<div class="modal-content">
                <div class="modal-header">
    				<h5 class="modal-title" id="uploadNewImageModalLabel">Tambah Lampiran</h5>
    				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    			</div>
    			<div class="modal-body">
                    <form action="" class="dropzone mb-4" method="POST" id="my-awesome-dropzone" enctype="multipart/form-data">
                        <div class="dz-message">
                            Seret lampiran ke sini atau klik untuk memilih.
                        </div>
                    </form>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Selesai</button>
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
    <script src="<?= assets_url() ?>js/pages/admin/arsip/detail.js?v=<?= time() ?>"></script>
</body>

</html>