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
                              <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                              <li class="breadcrumb-item"><a href="<?= base_url('admin/kode-klasifikasi') ?>" class="link">Kode Klasifikasi</a></li>
                              <li id="breadcrumb-nama" class="breadcrumb-item active" aria-current="page"><image src="/assets/images/loader/loading.svg"/></li>
                            </ol>
                          </nav>
                        <h1 id="klasifikasi-title" class="mb-0 fw-bold"><image src="/assets/images/loader/loading.svg"/></h1> 
                    </div>
                    <div class="col-6">
                        <div class="text-end upgrade-btn">
                            <a href="<?= base_url('admin/kode-klasifikasi') ?>" class="btn btn-primary text-white">
                                <i class="mdi mdi-arrow-left"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-30"> 
                                    <div style="height: 150px; width: 150px; border-radius: 150px;" class="bg-primary d-flex justify-content-center align-items-center">
                                        <h1 id="kode-text" class="text-white mb-0"><image src="/assets/images/loader/loading-light.svg"/></h1>
                                    </div>
                                    <h4 id="nama-text" class="card-title m-t-10"><image src="/assets/images/loader/loading.svg"/></h4>
                                    <h6 id="deskripsi-text" class="card-subtitle"><image src="/assets/images/loader/loading.svg"/></h6>
                                    <a id="editKodeKlasifikasiBtn" href="javascript:void(0)"><small><i class="mdi mdi-pencil"></i> Ubah</small></a>
                                </center>
                            </div>
                            <div>
                                <hr>
                            </div>
                            <div class="card-body">
                                <small class="text-muted">Total arsip</small>
                                <h6 id="arsip-count-text"><image src="/assets/images/loader/loading.svg"/></h6>
                                <small class="text-muted p-t-30 db">Terakhir diubah</small>
                                <h6 id="last-updated-text"><image src="/assets/images/loader/loading.svg"/></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-12 col-md-3">
                                        <label for="search-table">Cari</label>
                                        <input type="text" name="search" id="search-table" class="form-control" placeholder="Cari">
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label for="status-table">Status</label>
                                        <select name="sort" id="status-table" class="form-control">
                                            <option value="semua">Semua</option>
                                            <option value="draft">Draft</option>
                                            <option value="publikasi">Publikasi</option>
                                            <option value="dihapus">Dihapus</option>
                                        </select>
                                    </div>
                                    <?php if($this->myrole->is('arsip_semua')) { ?>
                                    <div class="col-12 col-md-3">
                                        <label for="level-table">Level</label>
                                        <select name="sort" id="level-table" class="form-control">
                                            <option value="semua" selected>Semua</option>
                                            <option value="publik">Publik</option>
                                            <option value="rahasia">Rahasia</option>
                                        </select>
                                    </div>
                                    <?php } ?>
                                    <div class="col-12 col-md-3">
                                        <label for="sort-table">Urutkan</label>
                                        <select name="sort" id="sort-table" class="form-control">
                                            <option value="terbaru">Terbaru</option>
                                            <option value="terlama">Terlama</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="arsip-table" class="table">
                                        <thead>
                                            <tr>
                                                <th style="white-space: nowrap">Nomor</th>
                                                <th style="white-space: nowrap">Pengolah</th>
                                                <th style="white-space: nowrap">Uraian Informasi</th>
                                                <th style="white-space: nowrap">Lampiran</th>
                                                <th style="white-space: nowrap">Pencipta</th>
                                                <th style="white-space: nowrap">Tahun</th>
                                                <th style="white-space: nowrap">Status</th>
                                                <th style="white-space: nowrap">Level</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr><td colspan="8" class="text-center"><image src="/assets/images/loader/loading.svg"/></td></tr>
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
    <div class="modal fade" id="editKodeKlasifikasiModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="editKodeKlasifikasiModalLabel" aria-hidden="true">
    	<div class="modal-dialog modal-dialog-centered">
    		<div class="modal-content">
    			<div class="modal-header">
    				<h5 class="modal-title" id="editKodeKlasifikasiModalLabel">Ubah data</h5>
    				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    			</div>
    			<form id="edit-klasifikasi-form" method="post" class="modal-body">
    				<div class="mb-3">
                        <label for="">Kode</label>
                        <input id="kode-input" type="text" class="form-control" value="">
                    </div>
    				<div class="mb-3">
                        <label for="">Nama</label>
                        <input id="nama-input" type="text" class="form-control" value="">
                    </div>
    				<div class="mb-3">
                        <label for="">Deskripsi</label>
                        <textarea name="" id="deskripsi-textarea" rows="2" class="form-control"></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
    			</div>
    		</div>
    	</div>
    </div>
    <?php include_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'base_js.php'); ?>
    <script src="<?= assets_url() ?>js/pages/admin/klasifikasi/detail.js?v=<?= time() ?>"></script>
    <script>
        $('#editKodeKlasifikasiBtn').on('click', function() {
            $('#editKodeKlasifikasiModal').modal('show')
        })
    </script>
</body>

</html>