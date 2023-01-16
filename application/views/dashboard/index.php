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
                              <li class="breadcrumb-item"><a href="index.html" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                          </nav>
                        <h1 class="mb-0 fw-bold">Dashboard</h1> 
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <form class="row" method="GET">
                                    <div class="col-12">
                                        <h4 class="card-title">Filter statistik</h4>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="">Tanggal awal</label>
                                        <input type="date" name="start" id="start-date-input" value="<?= $this->input->get('start', true) ?>" class="form-control">
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="">Tanggal akhir</label>
                                        <input type="date" name="end" id="end-date-input" value="<?= $this->input->get('end', true) ?>" class="form-control">
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label for="" class="d-none d-lg-block">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary"><i class="bi bi-funnel-fill"></i> Filter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Total Pengunjung Arsip</h4>
                                <h1><?= $total_viewers ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Jumlah Arsip Dipublikasi</h4>
                                        <!-- <h6 class="card-subtitle">Jumlah arsip dipublikasi 2 minggu terakhir</h6> -->
                                    </div>
                                    <div class="ms-auto d-flex no-block align-items-center">
                                        <ul class="list-inline dl d-flex align-items-center m-r-15 m-b-0">
                                            <li class="list-inline-item d-flex align-items-center text-info">
                                                <i class="fa fa-circle font-10 me-1"></i> Arsip
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="amp-pxl mt-4" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Klasifikasi Terbanyak</h4>
                                <h6 class="card-subtitle">Klasifikasi dengan Arsip Dipublikasi Terbanyak</h6>
                                <div id="klasifikasi-top5" class=""></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Jumlah Pengunjung Arsip</h4>
                                    </div>
                                    <div class="ms-auto d-flex no-block align-items-center">
                                        <ul class="list-inline dl d-flex align-items-center m-r-15 m-b-0">
                                            <li class="list-inline-item d-flex align-items-center text-info">
                                                <i class="fa fa-circle font-10 me-1"></i> Pengunjung
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="arsip-dilihat-chart mt-4" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Top Arsip</h4>
                                <h6 class="card-subtitle">Arsip dengan Kunjungan Terbanyak</h6>
                                <div id="arsip-top5" class=""></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- column -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- title -->
                                <div class="d-md-flex">
                                    <div>
                                        <h4 class="card-title">Arsip Terakhir Ditambahkan</h4>
                                        <h5 class="card-subtitle">5 Arsip Terakhir Ditambahkan</h5>
                                    </div>
                                </div>
                                <!-- title -->
                                <div class="table-responsive">
                                    <table id="arsip-table" class="table mb-0 table-hover align-middle text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">No</th>
                                                <th class="border-top-0">Pengolah</th>
                                                <th class="border-top-0">Kode Klasifikasi</th>
                                                <th class="border-top-0">Uraian Informasi</th>
                                                <th class="border-top-0">Lampiran</th>
                                                <th class="border-top-0">Pencipta</th>
                                                <th class="border-top-0">Tanggal</th>
                                                <th class="border-top-0">Status</th>
                                                <th class="border-top-0">Level</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(false) { ?>
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
                <?php } ?>
        </div>
    </div>
    <?php include_once(__DIR__.'/components/base_js.php'); ?>
    <script src="<?= assets_url() ?>js/pages/dashboards/index.js?v=<?= time() ?>"></script>
    <script>
        $('#arsip-table tr').on('click', function() {
            window.location.href = '/arsip/detail'
        })
    </script>
</body>

</html>