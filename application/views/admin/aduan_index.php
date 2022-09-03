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
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 d-flex align-items-center">
                              <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                              <li class="breadcrumb-item active" aria-current="page">Aduan</li>
                            </ol>
                        </nav>
                        <div class="d-flex justify-content-between">
                            <h1 class="mb-0 fw-bold">Aduan</h1>
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
                                <div class="table-responsive">
                                    <table id="aduan-table" class="table mb-4 table-hover align-middle text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Nomor</th>
                                                <th class="border-top-0">Aduan</th>
                                                <th class="border-top-0">Nama</th>
                                                <th class="border-top-0">Email</th>
                                                <th class="border-top-0">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <div class="d-flex justify-content-end mb-3">
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
    </div>
    <?php include_once(__DIR__.'/components/base_js.php'); ?>
    <script src="<?= assets_url() ?>js/pages/admin/aduan/index.js?v=<?= time() ?>"></script>
    <!-- <script>
        $('tr').on('click', function() {
            window.location.href = '<?= base_url() ?>admin/aduan/detail/'+$(this).data('id')
        })
    </script> -->
</body>

</html>