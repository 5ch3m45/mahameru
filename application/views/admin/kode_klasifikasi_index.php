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
                                <!-- title -->
                                <div class="table-responsive" style="min-height: 30rem">
                                    <table class="table mb-0 table-hover align-middle text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Nama</th>
                                                <th class="border-top-0">Kode</th>
                                                <th class="border-top-0">Keterangan</th>
                                                <th class="border-top-0">Jumlah Arsip</th>
                                                <th class="border-top-0">Terakhir Diubah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($klasifikasis as $key => $klasifikasi) { ?>
                                            <tr role="button" data-id="<?= $klasifikasi['id'] ?>">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="m-r-10">
                                                            <button class="btn-primary btn-circle p-0 border-0"><?= $klasifikasi['kode'] ?></button>
                                                        </div>
                                                        <div class="">
                                                            <h4 class="m-b-0 font-16"><?= $klasifikasi['nama'] ?></h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?= $klasifikasi['kode'] ?></td>
                                                <td><?= $klasifikasi['deskripsi'] ?></td>
                                                <td><?= $klasifikasi['arsip_count'] ?></td>
                                                <td><?= date_format(date_create($klasifikasi['updated_at']), 'd-m-Y') ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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
                        <label for="">Kode</label>
                        <input id="kodeInput" type="text" class="form-control">
                        <div id="kodeError" class="error-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="">Nama</label>
                        <input id="namaInput" type="text" class="form-control">
                        <div id="namaError" class="error-text"></div>
                    </div>
    				<div class="mb-3">
                        <label for="">Keterangan</label>
                        <textarea id="deskripsiTextarea" class="form-control" rows="3"></textarea>
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
    <?php include_once(__DIR__.'/components/base_js.php'); ?>
    <script src="<?= assets_url() ?>js/pages/admin/klasifikasi/index.js?v=<?= time() ?>"></script>
</body>

</html>