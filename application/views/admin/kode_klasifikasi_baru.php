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
                              <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                              <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="link">Admin</a></li>
                              <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="link">Kode Klasifikasi</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Buat Baru</li>
                            </ol>
                          </nav>
                        <h1 class="mb-0 fw-bold">Kode Klasifikasi Baru</h1> 
                    </div>
                    <div class="col-6">
                        <div class="text-end upgrade-btn">
                            <a href="<?= base_url('kode-klasifikasi') ?>" 
                                class="btn btn-primary text-white">
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
                <div class="row">
                    <!-- column -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="formKodeKlasifikasi">
                                    <div class="mb-3">
                                        <label for="">Kode</label>
                                        <input name="kode" type="text" class="form-control">
                                    </div>
                                    <div class="mb-5">
                                        <label for="">Nama</label>
                                        <input name="nama" type="text" class="form-control">
                                    </div>
                                    <div class="mb-5">
                                        <label for="">Deskripsi</label>
                                        <input name="deskripsi" type="text" class="form-control">
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a href="<?= base_url('kode-klasifikasi') ?>">
                                            <button class="btn btn-light me-2">Batal</button>
                                        </a>
                                        <button id="submitKodeKlasifikasi" class="btn btn-primary">
                                            <i class="mdi mdi-content-save"></i> Simpan
                                        </button>
                                    </div>
                                </div>
                                <div id="success" style="display: none">
                                    <div id="lottie" style="height:300px"></div>
                                    <div class="text-center">
                                        <p>Kode klasifikasi berhasil disimpan. <a href="<?= base_url('kode-klasifikasi/detail') ?>">Lihat kode klasifikasi</a> atau <a id="createNewKodeKlasifikasi" href="javascript:void(0)">buat baru lagi?</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <?php include_once(__DIR__.'/components/base_js.php'); ?>
    <script>
     var animation = bodymovin.loadAnimation({
        container: document.getElementById('lottie'), // Required
        path: '<?= assets_url().'libs/lottie-interactivity/animations/check-mark.json' ?>', // Required
        renderer: 'svg', // Required
        loop: false, // Optional
        autoplay: false, // Optional
    })

    $(document).ready(function() {
        $('#submitKodeKlasifikasi').on('click', function() {
            $('#formKodeKlasifikasi').hide();
            $('#success').show();
            animation.play();
        })

        $('#createNewKodeKlasifikasi').on('click', function() {
            animation.stop();
            $('input[name=kode]').val('')
            $('input[name=nama]').val('')
            $('input[name=deskripsi]').val('')
            $('#formKodeKlasifikasi').show();
            $('#success').hide();
        })
    })
    </script>
</body>

</html>