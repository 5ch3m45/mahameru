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
                              <li class="breadcrumb-item"><a href="index.html" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                          </nav>
                        <h1 class="mb-0 fw-bold">Dashboard</h1> 
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
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Arsip Ditambahkan</h4>
                                        <h6 class="card-subtitle">Jumlah Arsip Ditambahkan di Bulan Ini</h6>
                                    </div>
                                    <div class="ms-auto d-flex no-block align-items-center">
                                        <ul class="list-inline dl d-flex align-items-center m-r-15 m-b-0">
                                            <li class="list-inline-item d-flex align-items-center text-info">
                                                <i class="fa fa-circle font-10 me-1"></i> Arsip
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="amp-pxl mt-4" style="height: 350px;">
                                    <div class="chartist-tooltip"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Klasifikasi Terbanyak</h4>
                                <h6 class="card-subtitle">Klasifikasi dengan Arsip Terbanyak</h6>
                                <div class="mt-5 pb-3 d-flex align-items-center">
                                    <span class="btn btn-primary btn-circle d-flex align-items-center p-0">
                                        &nbsp;
                                    </span>
                                    <div class="ms-3">
                                        <h5 class="mb-0 fw-bold">000</h5>
                                        <span class="text-muted fs-6">Umum</span>
                                    </div>
                                    <div class="ms-auto">
                                        <span class="badge bg-light text-muted">900 arsip</span>
                                    </div>
                                </div>
                                <div class="py-3 d-flex align-items-center">
                                    <span class="btn btn-warning btn-circle d-flex align-items-center">
                                        &nbsp;
                                    </span>
                                    <div class="ms-3">
                                        <h5 class="mb-0 fw-bold">050</h5>
                                        <span class="text-muted fs-6">Perencanaan</span>
                                    </div>
                                    <div class="ms-auto">
                                        <span class="badge bg-light text-muted">755 arsip</span>
                                    </div>
                                </div>
                                <div class="py-3 d-flex align-items-center">
                                    <span class="btn btn-success btn-circle d-flex align-items-center">
                                        &nbsp;
                                    </span>
                                    <div class="ms-3">
                                        <h5 class="mb-0 fw-bold">190</h5>
                                        <span class="text-muted fs-6">Hubungan Luar Negeri</span>
                                    </div>
                                    <div class="ms-auto">
                                        <span class="badge bg-light text-muted">650 arsip</span>
                                    </div>
                                </div>
                                <div class="py-3 d-flex align-items-center">
                                    <span class="btn btn-info btn-circle d-flex align-items-center">
                                        &nbsp;
                                    </span>
                                    <div class="ms-3">
                                        <h5 class="mb-0 fw-bold">260</h5>
                                        <span class="text-muted fs-6">Organisasi Wanita</span>
                                    </div>
                                    <div class="ms-auto">
                                        <span class="badge bg-light text-muted">554 arsip</span>
                                    </div>
                                </div>

                                <div class="pt-3 d-flex align-items-center">
                                    <span class="btn btn-danger btn-circle d-flex align-items-center">
                                        &nbsp;
                                    </span>
                                    <div class="ms-3">
                                        <h5 class="mb-0 fw-bold">420</h5>
                                        <span class="text-muted fs-6">Pendidikan</span>
                                    </div>
                                    <div class="ms-auto">
                                        <span class="badge bg-light text-muted">340 arsip</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Table -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- column -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- title -->
                                <div class="d-md-flex">
                                    <div>
                                        <h4 class="card-title">Terakhir Ditambahkan</h4>
                                        <h5 class="card-subtitle">5 Arsip Terakhir Ditambahkan</h5>
                                    </div>
                                </div>
                                <!-- title -->
                                <div class="table-responsive">
                                    <table id="arsip-table" class="table mb-0 table-hover align-middle text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">#</th>
                                                <th class="border-top-0">No. Awal</th>
                                                <th class="border-top-0">Kode Klasifikasi</th>
                                                <th class="border-top-0">Deskripsi Kegiatan</th>
                                                <th class="border-top-0">Dibuat Oleh</th>
                                                <th class="border-top-0">Lampiran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr role="button" data-id="1">
                                                <td>1</td>
                                                <td>2</td>
                                                <td>
                                                    <label class="badge bg-primary">
                                                        <strong>000</strong> | Umum
                                                    </label>
                                                </td>
                                                <td>
                                                    <small class="d-inline-block text-truncate" style="max-width: 250px;">Pengambilan Sumpah Jabatan Pengurus Darma Wanita Kabupaten Wonosobo Tahun 2022</small>
                                                </td>
                                                <td>
                                                    <label class="badge bg-danger">BMF</label>
                                                </td>
                                                <td>
                                                    <ul class="avatars">
                                                        <li class="avatars__item">
                                                            <img src="<?= assets_url() ?>images/users/5.jpg" class="avatars__img" />
                                                        </li>
                                                        <li class="avatars__item">
                                                            <span class="avatars__initials">KD</span>
                                                        </li>
                                                        <li class="avatars__item">
                                                            <span class="avatars__others">+3</span>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr role="button" data-id="1">
                                                <td>2</td>
                                                <td>34</td>
                                                <td>
                                                    <label class="badge bg-danger">
                                                        <strong>420</strong> | Pendidikan
                                                    </label>
                                                </td>
                                                <td>
                                                    <small class="d-inline-block text-truncate" style="max-width: 250px;">Pengambilan Sumpah Jabatan Pengurus Darma Wanita Kabupaten Wonosobo Tahun 2022</small>
                                                </td>
                                                <td>
                                                    <label class="badge bg-danger">BMF</label>
                                                </td>
                                                <td>
                                                    <ul class="avatars">
                                                        <li class="avatars__item">
                                                            <img src="<?= assets_url() ?>images/users/5.jpg" class="avatars__img" />
                                                        </li>
                                                        <li class="avatars__item">
                                                            <span class="avatars__initials">KD</span>
                                                        </li>
                                                        <li class="avatars__item">
                                                            <span class="avatars__others">+3</span>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr role="button" data-id="1">
                                                <td>1</td>
                                                <td>2</td>
                                                <td>
                                                    <label class="badge bg-info">
                                                        <strong>260</strong> | Organisasi Wanita
                                                    </label>
                                                </td>
                                                <td>
                                                    <small class="d-inline-block text-truncate" style="max-width: 250px;">Pengambilan Sumpah Jabatan Pengurus Darma Wanita Kabupaten Wonosobo Tahun 2022</small>
                                                </td>
                                                <td>
                                                    <label class="badge bg-danger">BMF</label>
                                                </td>
                                                <td>
                                                    <ul class="avatars">
                                                        <li class="avatars__item">
                                                            <img src="<?= assets_url() ?>images/users/5.jpg" class="avatars__img" />
                                                        </li>
                                                        <li class="avatars__item">
                                                            <span class="avatars__initials">KD</span>
                                                        </li>
                                                        <li class="avatars__item">
                                                            <span class="avatars__others">+3</span>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr role="button" data-id="1">
                                                <td>1</td>
                                                <td>2</td>
                                                <td>
                                                    <label class="badge bg-success">
                                                        <strong>190</strong> | Hubungan Luar Negeri
                                                    </label>
                                                </td>
                                                <td>
                                                    <small class="d-inline-block text-truncate" style="max-width: 250px;">Pengambilan Sumpah Jabatan Pengurus Darma Wanita Kabupaten Wonosobo Tahun 2022</small>
                                                </td>
                                                <td>
                                                    <label class="badge bg-danger">BMF</label>
                                                </td>
                                                <td>
                                                    <ul class="avatars">
                                                        <li class="avatars__item">
                                                            <img src="<?= assets_url() ?>images/users/5.jpg" class="avatars__img" />
                                                        </li>
                                                        <li class="avatars__item">
                                                            <span class="avatars__initials">KD</span>
                                                        </li>
                                                        <li class="avatars__item">
                                                            <span class="avatars__others">+3</span>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr role="button" data-id="1">
                                                <td>1</td>
                                                <td>2</td>
                                                <td>
                                                    <label class="badge bg-warning">
                                                        <strong>050</strong> | Perencanaan
                                                    </label>
                                                </td>
                                                <td>
                                                    <small class="d-inline-block text-truncate" style="max-width: 250px;">Pengambilan Sumpah Jabatan Pengurus Darma Wanita Kabupaten Wonosobo Tahun 2022</small>
                                                </td>
                                                <td>
                                                    <label class="badge bg-danger">BMF</label>
                                                </td>
                                                <td>
                                                    <ul class="avatars">
                                                        <li class="avatars__item">
                                                            <img src="<?= assets_url() ?>images/users/5.jpg" class="avatars__img" />
                                                        </li>
                                                        <li class="avatars__item">
                                                            <span class="avatars__initials">KD</span>
                                                        </li>
                                                        <li class="avatars__item">
                                                            <span class="avatars__others">+3</span>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Table -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Recent comment and chats -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Catatan Terbaru</h4>
                            </div>
                            <div class="comment-widgets scrollable">
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row m-t-0">
                                    <div class="p-2"><img src="<?= assets_url() ?>images/users/1.jpg" alt="user" width="50"
                                            class="rounded-circle"></div>
                                    <div class="comment-text w-100">
                                        <h6 class="font-medium">Hani Kusmawati</h6>
                                        <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing
                                            and type setting industry. </span>
                                        <div class="comment-footer">
                                            <span class="text-muted float-end">April 14, 2021</span> 
                                            <span
                                                class="action-icons">
                                                <a href="javascript:void(0)"><i class="ti-pencil-alt"></i> Edit</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row">
                                    <div class="p-2"><img src="<?= assets_url() ?>images/users/4.jpg" alt="user" width="50"
                                            class="rounded-circle"></div>
                                    <div class="comment-text active w-100">
                                        <h6 class="font-medium">Julia Rahimah</h6>
                                        <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing
                                            and type setting industry. </span>
                                        <div class="comment-footer ">
                                            <span class="text-muted float-end">April 14, 2021</span>
                                            
                                            <span class="action-icons">
                                                <a href="javascript:void(0)"><i class="ti-pencil-alt"></i> Edit</a>
                                            
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row">
                                    <div class="p-2"><img src="<?= assets_url() ?>images/users/5.jpg" alt="user" width="50"
                                            class="rounded-circle"></div>
                                    <div class="comment-text w-100">
                                        <h6 class="font-medium">Harja Budiman</h6>
                                        <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing
                                            and type setting industry. </span>
                                        <div class="comment-footer">
                                            <span class="text-muted float-end">April 14, 2021</span>
                                            <span class="action-icons">
                                                <a href="javascript:void(0)"><i class="ti-pencil-alt"></i> Edit</a>
                                            
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Aktivitas Terbaru</h4>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="d-flex flex-row comment-row m-t-0">
                                            <div class="p-2">
                                                <img src="http://mahameru.test/assets/images/users/1.jpg" alt="user" width="50" class="rounded-circle">
                                            </div>
                                            <div class="comment-text w-100 d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Harja Budiman</div>
                                                    <span class="badge bg-warning">Mengubah</span> arsip #366
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex flex-row comment-row m-t-0">
                                            <div class="p-2">
                                                <img src="http://mahameru.test/assets/images/users/1.jpg" alt="user" width="50" class="rounded-circle">
                                            </div>
                                            <div class="comment-text w-100 d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Rusman Marbun</div>
                                                    <span class="badge bg-info">Mengunggah</span> lampiran arsip #444
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex flex-row comment-row m-t-0">
                                            <div class="p-2">
                                                <img src="http://mahameru.test/assets/images/users/1.jpg" alt="user" width="50" class="rounded-circle">
                                            </div>
                                            <div class="comment-text w-100 d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Lalita Uyainah</div>
                                                    <span class="badge bg-success">Menambah</span> arsip #123
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex flex-row comment-row m-t-0">
                                            <div class="p-2">
                                                <img src="http://mahameru.test/assets/images/users/1.jpg" alt="user" width="50" class="rounded-circle">
                                            </div>
                                            <div class="comment-text w-100 d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Lalita Uyainah</div>
                                                    <span class="badge bg-danger">Menghapus</span> arsip #543
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Recent comment and chats -->
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
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <?php include_once(__DIR__.'/components/base_js.php'); ?>
    <script src="<?= assets_url() ?>js/pages/dashboards/dashboard1.js?v=<?= time() ?>"></script>
    <script>
        $('#arsip-table tr').on('click', function() {
            window.location.href = '/arsip/detail'
        })
    </script>
</body>

</html>