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
                </div>
            </div>
            
            <div class="container-fluid">
                <div class="row">
                    <!-- column -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-12 col-md-3">
                                        <label for="search-table">Cari</label>
                                        <input type="text" name="search" id="search-table" class="form-control" placeholder="Cari">
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label for="search-table">Status</label>
                                        <select name="sort" id="sort-table" class="form-control">
                                            <option value="semua">Semua</option>
                                            <option value="draft">Draft</option>
                                            <option value="publikasi">Publikasi</option>
                                            <option value="dihapus">Dihapus</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label for="search-table">Level</label>
                                        <select name="sort" id="sort-table" class="form-control">
                                            <option value="semua">Semua</option>
                                            <option value="publik">Publik</option>
                                            <option value="rahasia">Rahasia</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label for="search-table">Urutkan</label>
                                        <select name="sort" id="sort-table" class="form-control">
                                            <option value="terbaru">Terbaru</option>
                                            <option value="terlama">Terlama</option>
                                            <option value="nomor">Nomor</option>
                                            <option value="pencipta">Pencipta</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- title -->
                                <div class="table-responsive">
                                    <table id="arsip-table" class="table mb-4 table-hover align-middle text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">#</th>
                                                <th class="border-top-0">No</th>
                                                <th class="border-top-0">Inisial Pengolah</th>
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
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" id="prev-table" class="btn btn-primary me-2">Sebelumnya</button>
                                    <button type="button" disabled id="page-table" class="btn btn-light me-2">1/1</button>
                                    <button type="button" id="next-table" class="btn btn-primary">Selanjutnya</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once(__DIR__.'/../components/base_js.php'); ?>
    <script src="<?= assets_url() ?>js/pages/admin/arsip/index.js?v=<?= time() ?>"></script>
    <script>
        $('tr').on('click', function() {
            window.location.href = '<?= base_url() ?>admin/arsip/detail/'+$(this).data('id')
        })
    </script>
</body>

</html>