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
                            <a href="<?= base_url('dashboard/arsip/baru') ?>">
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
                                <form id="filter-form" action="<?= base_url('dashboard/arsip') ?>" class="row mb-4">
                                    <input type="hidden" name="page" value="<?= $current_page ?>" id="page-input">
                                    <div class="col-12 col-md-3">
                                        <label for="search-table">Cari</label>
                                        <input type="text" name="search" value="<?= $search ?>" id="search-table" class="form-control" placeholder="Cari">
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label for="status-table">Status</label>
                                        <select name="status" id="status-table" class="form-control">
                                            <option value="semua" <?= !$status || $status == 'semua' ? 'selected' : '' ?>>Semua</option>
                                            <option value="draft" <?= $status == 'draft' ? 'selected' : '' ?>>Draft</option>
                                            <option value="publikasi" <?= $status == 'publikasi' ? 'selected' : '' ?>>Publikasi</option>
                                            <option value="dihapus" <?= $status == 'dihapus' ? 'selected' : '' ?>>Dihapus</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label for="level-table">Level</label>
                                        <select name="level" id="level-table" class="form-control">
                                            <option value="semua" <?= !$level || $level == 'semua' ? 'selected' : '' ?>>Semua</option>
                                            <option value="publik" <?= $level == 'publik' ? 'selected' : '' ?>>Publik</option>
                                            <option value="rahasia" <?= $level == 'rahasia' ? 'selected' : '' ?>>Rahasia</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label for="sort-table">Urutkan</label>
                                        <select name="sort" id="sort-table" class="form-control">
                                            <option value="terbaru" <?= !$sort || $sort == 'terbaru' ? 'selected':'' ?>>Terbaru</option>
                                            <option value="terlama" <?= $sort == 'terlama' ? 'selected':'' ?>>Terlama</option>
                                            <option value="terpopuler" <?= $sort == 'terpopuler' ? 'selected':'' ?>>Terpopuler</option>
                                            <option value="nomoraz" <?= $sort == 'nomoraz' ? 'selected':'' ?>>Nomor (A-Z)</option>
                                            <option value="nomorza" <?= $sort == 'nomorza' ? 'selected':'' ?>>Nomor (Z-A)</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label for="sort-table">&nbsp;</label>
                                        <div>
                                            <button type="submit" class="btn btn-primary me-2"><i class="bi bi-search"></i> Cari</button>
                                            <a href="<?= base_url('dashboard/arsip') ?>">
                                                <button class="btn btn-light" type="button"><i class="bi bi-arrow-clockwise"></i> Reset</button>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                                <!-- title -->
                                <div class="table-responsive">
                                    <table id="arsip-table" class="table mb-4 table-hover align-middle text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">No</th>
                                                <th class="border-top-0">Kode Klasifikasi</th>
                                                <th class="border-top-0">Lampiran</th>
                                                <th class="border-top-0">Pengolah</th>
                                                <th class="border-top-0">Pencipta</th>
                                                <th class="border-top-0">Tanggal</th>
                                                <th class="border-top-0">Viewers</th>
                                                <th class="border-top-0">Status</th>
                                                <th class="border-top-0">Level</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($arsips as $key => $arsip) { ?>
                                                <tr>
                                                    <td>
                                                        <a class="text-primary" href="<?= base_url('dashboard/arsip/detail/'.$arsip['id']) ?>">
                                                            <?= $arsip['nomor'] ? $arsip['nomor'] : ''?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="<?= base_url('dashboard/kode-klasifikasi/detail/'.$arsip['klasifikasi_id']) ?>" class="badge bg-primary text-white text-truncate">
                                                            <?= @$arsip['klasifikasi']['kode'].'. '.(strlen(@$arsip['klasifikasi']['nama']) > 20 ? substr(@$arsip['klasifikasi']['nama'], 0, 20).'..' : @$arsip['klasifikasi']['nama']) ?>
                                                        </a>
                                                        <div>
                                                            <a class="text-primary" class="" href="<?= base_url('dashboard/arsip/detail/'.$arsip['id']) ?>">
                                                                <small class="d-inline-block" style="max-width: 250px;"><?= $arsip['informasi'] ? $arsip['informasi'] : ''?></small>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <ul class="avatars">
                                                            <?= lampiranParser($arsip['lampirans']) ?>
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <a class="text-primary" href="<?= base_url('dashboard/pengelola/detail/'.$arsip['admin_id']) ?>">
                                                            <?= $arsip['admin_id'] ? $arsip['admin']['name'] : '-'?>
                                                        </a>
                                                    </td>
                                                    <td><?= $arsip['pencipta'] ? $arsip['pencipta'] : ''?></td>
                                                    <td><?= @$arsip['tanggal_formatted'] ? @$arsip['tanggal_formatted'] : ''?></td>
                                                    <td><i class="bi bi-eye"></i> <?= $arsip['viewers'] ?></td>
                                                    <td><?= statusParser($arsip['status'])?></td>
                                                    <td><?= $arsip['level'] == '2'
                                                        ? '<span class="badge bg-success">Publik</span>'
                                                        : '<span class="badge bg-danger">Rahasia</span>'
                                                    ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                	<a href="<?= $current_page > 1 ? base_url('dashboard/arsip?page='.($current_page -1 ).'&search='.$search.'&status='.$status.'&level='.$level.'&sort='.$sort) : '#' ?>" class="btn btn-primary"
                                		style="border-radius: 10px 0 0 10px">
                                        <span class="d-none d-md-block">Sebelumnya</span>
                                        <span class="d-md-none"><<</span>
                                    </a>
                                	<div class="input-group" style="width: auto">
                                		<span class="input-group-text d-none d-md-block" style="border-radius: 0!important">Halaman</span>
                                		<input type="text" id="current-page" value="<?= $current_page ?>"
                                			style="max-width: 3rem; padding: 0 10px; border-radius: 0!important">
                                		<span class="input-group-text" id="total-page"
                                			style="border-radius: 0px!important">dari <?= $total_page ?></span>
                                	</div>
                                	<a href="<?= $current_page < $total_page ? base_url('dashboard/arsip?page='.($current_page +1 ).'&search='.$search.'&status='.$status.'&level='.$level.'&sort='.$sort) : '#' ?>" class="btn btn-primary"
                                		style="border-radius: 0 10px 10px 0">
                                        <span class="d-none d-md-block">Selanjutnya</span>
                                        <span class="d-md-none">>></span>
                                    </a>
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
</body>

</html>