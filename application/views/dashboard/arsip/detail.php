<!DOCTYPE html>
<html dir="ltr" lang="en">

<?php include_once(__DIR__.'/../components/html_head.php'); ?>

<body>
    <?php include_once(__DIR__.'/../components/preloader.php'); ?>
    <div 
        id="main-wrapper" 
        data-layout="vertical" 
        data-navbarbg="skin5" 
        data-sidebartype="full"
        data-sidebar-position="absolute" 
        data-header-position="absolute" 
        data-boxed-layout="full">
        <?php include_once(__DIR__.'/../components/top_bar.php'); ?>
        <?php include_once(__DIR__.'/../components/left_sidebar.php'); ?>
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-6">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 d-flex align-items-center">
                              <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                              <li class="breadcrumb-item"><a href="<?= base_url('dashboard/arsip') ?>" class="link">Arsip</a></li>
                              <li id="nomor-arsip-breadcrumb" class="breadcrumb-item active" aria-current="page"><image src="/assets/images/loader/loading.svg"/></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-6">
                        <div class="text-end upgrade-btn">
                            <a href="<?= base_url('dashboard/arsip') ?>" class="btn btn-primary text-white">
                                <i class="mdi mdi-arrow-left"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="d-flex">
                    <h1 id="nomor-arsip-title" class="mb-0 fw-bold me-2"><image src="/assets/images/loader/loading.svg"/></h1>
                    <div id="status-flag" class="ms-1 my-auto py-auto"></div>
                </div>
                <hr>            
                <div class="d-flex justify-content-between">
                    <div>
                        <button id="ubahInformasiBtn" class="btn btn-text text-primary me-2 mb-2 mb-md-0"><i class="bi bi-pencil-square"></i> Ubah informasi</button>
                        <button id="uploadNewImageBtn" class="btn btn-text text-primary mb-2 mb-md-0"><i class="bi bi-cloud-arrow-up-fill"></i> Upload lampiran</button>
                    </div>
                    <div>
                        <button id="publikasiBtn" style="display: none" class="btn btn-success text-white me-2 mb-2 mb-md-0"><i class="bi bi-share-fill"></i> Publikasi</button>
                        <button id="draftBtn" style="display: none" class="btn btn-warning me-2 mb-2 mb-md-0"><i class="bi bi-input-cursor-text"></i> Simpan sebagai draft</button>
                        <button id="delete-arsip-btn" style="display: none" class="btn btn-danger text-white mb-2 mb-md-0 me-2"><i class="bi bi-trash3-fill"></i> Hapus</button>
                        <button id="restore-btn" style="display: none" class="btn btn-success text-white mb-2 mb-md-0 me-2"><i class="bi bi-arrow-counterclockwise"></i> Kembalikan</button>
                    </div>
                </div>
                <hr>
                <!-- Row -->
                <div class="row d-flex align-items-stretch">
                    <!-- Column -->
                    <div class="col-12">
                        <div class="card rounded-corner">
                            <div class="card-body">
                                <p id="informasi-text"><image src="/assets/images/loader/loading.svg"/></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <small class="text-muted">Level</small>
                                <h6 id="level-text"><image src="/assets/images/loader/loading.svg"/></h6>
                                <small class="text-muted">Nomor</small>
                                <h6 id="nomor-arsip-text"><image src="/assets/images/loader/loading.svg"/></h6>
                                <small class="text-muted p-t-30 db">Kode klasifikasi</small>
                                <h6 id="klasifikasi-arsip-text"><image src="/assets/images/loader/loading.svg"/></h6>
                                <small class="text-muted p-t-30 db">Pencipta</small>
                                <h6 id="pencipta-arsip-text"><image src="/assets/images/loader/loading.svg"/></h6>
                                <small class="text-muted p-t-30 db">Tanggal Arsip</small>
                                <h6 id="tanggal-arsip-text"><image src="/assets/images/loader/loading.svg"/></h6>
                                <small class="text-muted p-t-30 db">Terakhir diupdate</small>
                                <h6 id="last-updated-text"><image src="/assets/images/loader/loading.svg"/></h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card mb-0">
                            <div class="card-body">
                            	<div class="my-masonry-grid"><image src="/assets/images/loader/loading.svg"/></div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <div class="modal fade" id="lampiranDetailModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="lampiranDetailModalLabel" aria-hidden="true">
    	<div class="modal-dialog modal-dialog-centered modal-xl d-flex justify-content-center">
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
    				<h5 class="modal-title" id="hapusLampiranConfirmModalLabel">Hapus Lampiran</h5>
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
    <div class="modal fade" id="restoreModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
    	<div class="modal-dialog modal-dialog-centered">
    		<form id="restore-form" action="/api/dashboard/arsip/<?= $arsip['id'] ?>/restore" method="POST" class="modal-content">
                <div class="modal-header">
    				<h5 class="modal-title" id="restoreModalLabel">Kembalikan Arsip</h5>
    				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    			</div>
    			<div class="modal-body">
                    <p>Anda akan mengembalikan arsip ini. Yakin?</p>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success text-white ms-2" data-id="">Kembalikan</button>
                    </div>
    			</div>
            </form>
    	</div>
    </div>
    <div class="modal fade" id="deleteArsipModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="deleteArsipModalLabel" aria-hidden="true">
    	<div class="modal-dialog modal-dialog-centered">
    		<form id="delete-arsip-form" action="/api/dashboard/arsip/<?= $arsip['id'] ?>/delete" method="POST" class="modal-content">
                <div class="modal-header">
    				<h5 class="modal-title" id="deleteArsipModalLabel">Hapus Arsip</h5>
    				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    			</div>
    			<div class="modal-body">
                    <p>Anda akan menghapus arsip ini. Yakin?</p>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger text-white ms-2" data-id="">Hapus</button>
                    </div>
    			</div>
            </form>
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
                        <label for="">Level Arsip</label>
                        <select name="level" id="level-select" class="form-select">
                            <option value="2">Publik</option>
                            <option value="1">Rahasia</option>
                        </select>
                        <div id="nomorError" class="error-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="">Nomor</label>
                        <input id="nomorInput" type="text" class="form-control" value="">
                        <div id="nomorError" class="error-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="">Tanggal</label>
                        <input id="tanggalInput" type="date" class="form-control" value="">
                        <div id="tanggalError" class="error-text"></div>
                    </div>
    				<div class="mb-3">
                        <label for="">Kode Klasifikasi</label>
                        <select id="klasifikasiSelect" name="klasifikasi" class="form-select">
                            <option selected></option>
                        </select>
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
                        <button type="button" id="doneUploadLampiran" class="btn btn-light me-2">Selesai</button>
                    </div>
    			</div>
    		</div>
    	</div>
    </div>
    <?php include_once(__DIR__.'/../components/base_js.php'); ?>
    <script src="<?= assets_url() ?>js/pages/admin/arsip/detail.js?v=<?= time() ?>"></script>
</body>
</html>