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
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 d-flex align-items-center">
                              <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                              <li class="breadcrumb-item active" aria-current="page">Arsip</li>
                            </ol>
                        </nav>
                        <div class="d-flex justify-content-between">
                            <h1 class="mb-0 fw-bold">Arsip</h1> 
                            <a href="/admin/arsip/baru">
                                <button class="btn btn-primary rounded-corner">Upload Baru</button>
                            </a>
                        </div>
                    </div>
                    <!-- <div class="col-6">
                        <div class="text-end upgrade-btn">
                            <a href="https://www.wrappixel.com/templates/flexy-bootstrap-admin-template/" class="btn btn-primary text-white"
                                target="_blank">Upgrade to Pro</a>
                        </div>
                    </div> -->
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
                                <!-- title -->
                                <div class="table-responsive">
                                    <table class="table mb-0 table-hover align-middle text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">#</th>
                                                <th class="border-top-0">No</th>
                                                <th class="border-top-0">Inisial Pengolah</th>
                                                <th class="border-top-0">Kode Klasifikasi</th>
                                                <th class="border-top-0">Uraian Informasi</th>
                                                <th class="border-top-0">Lampiran</th>
                                                <th class="border-top-0">Pencipta</th>
                                                <th class="border-top-0">Tahun</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($arsips as $key => $arsip) { ?>
                                            <tr role="button" data-id="<?= $arsip['id'] ?>">
                                                <td><?= $key + 1 ?></td>
                                                <td><?= $arsip['nomor'] ?></td>
                                                <td>BMF</td>
                                                <td>
                                                    <label class="badge bg-primary">
                                                        <?= $arsip['klasifikasi_id'] ?>: Kepegawaian
                                                    </label>
                                                </td>
                                                <td>
                                                    <small class="d-inline-block text-truncate" style="max-width: 250px;"><?= $arsip['informasi'] ?></small>
                                                </td>
                                                <td>
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
    <script src="<?= assets_url() ?>js/pages/dashboards/dashboard1.js?v=<?= time() ?>"></script>
    <script>
        $('tr').on('click', function() {
            window.location.href = '<?= base_url() ?>admin/arsip/detail/'+$(this).data('id')
        })
    </script>
</body>

</html>