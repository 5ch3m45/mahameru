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
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php include_once(__DIR__.'/components/top_bar.php'); ?>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include_once(__DIR__.'/components/left_sidebar.php'); ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-6">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 d-flex align-items-center">
                              <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                              <li class="breadcrumb-item"><a href="<?= base_url('admin/kode-klasifikasi') ?>" class="link">Kode Klasifikasi</a></li>
                              <li class="breadcrumb-item active" aria-current="page"><?= $klasifikasi['nama'] ?></li>
                            </ol>
                          </nav>
                        <h1 class="mb-0 fw-bold"><?= $klasifikasi['kode'] ?>: <?= $klasifikasi['nama'] ?></h1> 
                    </div>
                    <div class="col-6">
                        <div class="text-end upgrade-btn">
                            <a href="<?= base_url('kode-klasifikasi') ?>" class="btn btn-primary text-white">
                                <i class="mdi mdi-arrow-left"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-30"> 
                                    <div style="height: 150px; width: 150px; border-radius: 150px;" class="bg-primary d-flex justify-content-center align-items-center">
                                        <h1 class="text-white mb-0"><?= $klasifikasi['kode'] ?></h1>
                                    </div>
                                    <h4 class="card-title m-t-10"><?= $klasifikasi['nama'] ?></h4>
                                    <h6 class="card-subtitle"><?= $klasifikasi['deskripsi'] ?></h6>
                                    <a id="editKodeKlasifikasiBtn" href="javascript:void(0)"><small><i class="mdi mdi-pencil"></i> Ubah</small></a>
                                </center>
                            </div>
                            <div>
                                <hr>
                            </div>
                            <div class="card-body">
                                <small class="text-muted">Total arsip</small>
                                <h6><?= $arsipCount ?></h6>
                                <small class="text-muted p-t-30 db">Terakhir diubah</small>
                                <h6><?= date_format(date_create($klasifikasi['updated_at']), 'd-m-Y') ?></h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="white-space: nowrap">No</th>
                                                <th style="white-space: nowrap">Pengolah</th>
                                                <th style="white-space: nowrap">Uraian Informasi</th>
                                                <th style="white-space: nowrap">Lampiran</th>
                                                <th style="white-space: nowrap">Pencipta</th>
                                                <th style="white-space: nowrap">Tahun</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($arsips as $key => $arsip) { ?>
                                            <tr>
                                                <td><?= $key+1 ?></td>
                                                <td><?= $arsip['nomor'] ?></td>
                                                <td>BMF</td>
                                                <td><?= $arsip['informasi'] ?></td>
                                                <td>
                                                    <?php if($arsip['lampirans']) { ?>
                                                    <ul class="avatars">
                                                        <?php foreach($arsip['lampirans'] as $lampiran) { ?>
                                                        <li class="avatars__item">
                                                            <?php if($lampiran['type'] == 'image/jpeg' || $lampiran['type'] == 'image/png') { ?>
                                                                <img src="<?= $lampiran['url'] ?>" class="avatars__img" />
                                                            <?php } else if($lampiran['type'] == 'video/mp4') { ?>
                                                                <img src="/assets/images/mp4.png" class="avatars__img" />
                                                            <?php } else if($lampiran['type'] == 'number') { ?>
                                                                <span class="avatars__others">+<?= $lampiran['url'] ?></span>
                                                            <?php } ?>
                                                        </li>
                                                        <?php } ?>
                                                    </ul>
                                                    <?php } else { echo '-'; } ?>
                                                </td>
                                                <td><?= $arsip['pencipta'] ?></td>
                                                <td><?= $arsip['tahun'] ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                All Rights Reserved by Flexy Admin. Designed and Developed by <a
                    href="https://www.wrappixel.com">WrapPixel</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <div class="modal fade" id="editKodeKlasifikasiModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="editKodeKlasifikasiModalLabel" aria-hidden="true">
    	<div class="modal-dialog modal-dialog-centered">
    		<div class="modal-content">
    			<div class="modal-header">
    				<h5 class="modal-title" id="editKodeKlasifikasiModalLabel">Ubah data</h5>
    				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    			</div>
    			<div class="modal-body">
    				<div class="mb-3">
                        <label for="">Kode</label>
                        <input type="text" class="form-control" value="210">
                    </div>
    				<div class="mb-3">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" value="Kepegawaian">
                    </div>
    				<div class="mb-3">
                        <label for="">Deskripsi</label>
                        <textarea name="" id="" rows="2" class="form-control">Lorem ipsum dolor sit amet</textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary">Simpan</button>
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
    <script src="<?= assets_url() ?>js/pages/dashboards/dashboard1.js?v=<?= time() ?>"></script>
    <script>
        $('#editKodeKlasifikasiBtn').on('click', function() {
            $('#editKodeKlasifikasiModal').modal('show')
        })
    </script>
</body>

</html>