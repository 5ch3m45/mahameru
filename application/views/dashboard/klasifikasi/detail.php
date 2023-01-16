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
                              <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                              <li class="breadcrumb-item"><a href="<?= base_url('dashboard/klasifikasi') ?>" class="link">Kode Klasifikasi</a></li>
                              <li id="breadcrumb-nama" class="breadcrumb-item active" aria-current="page"><?= $klasifikasi['kode'] ?></li>
                            </ol>
                          </nav>
                        <h4 id="klasifikasi-title" class="mb-0 fw-bold">&nbsp;</h4> 
                    </div>
                    <div class="col-6">
                        <div class="text-end upgrade-btn">
                            <a href="<?= base_url('dashboard/klasifikasi') ?>" class="btn btn-primary text-white">
                                <i class="mdi mdi-arrow-left"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-30"> 
                                    <div style="height: 150px; width: 150px; border-radius: 150px;" class="bg-primary d-flex justify-content-center align-items-center">
                                        <h1 id="kode-text" class="text-white mb-0"><?= trim($klasifikasi['kode']).'.' ?></h1>
                                    </div>
                                    <h4 id="nama-text" class="m-t-10"><?= $klasifikasi['nama'] ?></h4>
                                    <h6 id="deskripsi-text" class="card-subtitle"><?= $klasifikasi['deskripsi'] ?></h6>
                                    <a id="editKodeKlasifikasiBtn" href="javascript:void(0)"><small><i class="mdi mdi-pencil"></i> Ubah</small></a>
                                </center>
                            </div>
                            <div>
                                <hr>
                            </div>
                            <div class="card-body">
                                <small class="text-muted">Total arsip</small>
                                <h6 id="arsip-count-text"><?= $klasifikasi['arsip_count'] ?></h6>
                                <small class="text-muted p-t-30 db">Terakhir diubah</small>
                                <h6 id="last-updated-text"><?= date('d m Y', strtotime($klasifikasi['updated_at'])) ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="filter-form" action="<?= base_url('dashboard/kode-klasifikasi/detail/'.$klasifikasi['id']) ?>" class="row mb-4">
                                    <input type="hidden" name="page" id="page-input" value="<?= $current_page ?>">
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
                                    <?php if($this->myrole->is('arsip_semua')) { ?>
                                    <div class="col-12 col-md-3">
                                        <label for="level-table">Level</label>
                                        <select name="level" id="level-table" class="form-control">
                                            <option value="semua" <?= !$level || $level == 'semua' ? 'selected' : '' ?>>Semua</option>
                                            <option value="publik" <?= $level == 'publik' ? 'selected' : '' ?>>Publik</option>
                                            <option value="rahasia" <?= $level == 'rahasia' ? 'selected' : '' ?>>Rahasia</option>
                                        </select>
                                    </div>
                                    <?php } ?>
                                    <div class="col-12 col-md-3">
                                        <label for="sort-table">Urutkan</label>
                                        <select name="sort" id="sort-table" class="form-control">
                                            <option value="terbaru" <?= !$sort || $sort == 'terbaru' ? 'selected' : '' ?>>Terbaru</option>
                                            <option value="terlama" <?= $sort == 'terlama' ? 'selected' : '' ?>>Terlama</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label for="sort-table">&nbsp;</label>
                                        <div>
                                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Cari</button>
                                            <a href="<?= base_url('dashboard/kode-klasifikasi/detail/'.$klasifikasi['id']) ?>" class="btn btn-light"><i class="bi bi-arrow-clockwise"></i> Reset</a>
                                        </div>
                                    </div>
                                </form>
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
                                            <?php foreach ($arsips as $key => $arsip) { ?>
                                                <tr>
                                                    <td>
                                                        <a class="text-primary" href="<?= base_url('dashboard/arsip/detail/'.$arsip['id']) ?>">
                                                            <?= $arsip['nomor'] ? $arsip['nomor'] : ''?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="text-primary" href="<?= base_url('dashboard/pengelola/detail/'.$arsip['admin_id']) ?>">
                                                            <?= $arsip['admin_id'] ? $arsip['admin_detail']['name'] : '-'?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="text-primary" class="" href="<?= base_url('dashboard/arsip/detail/'.$arsip['id']) ?>">
                                                            <small class="d-inline-block" style="max-width: 250px;"><?= $arsip['informasi'] ? $arsip['informasi'] : ''?></small>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <ul class="avatars">
                                                            <?= lampiranParser($arsip['lampirans']) ?>
                                                        </ul>
                                                    </td>
                                                    <td><?= $arsip['pencipta'] ? $arsip['pencipta'] : ''?></td>
                                                    <td><?= $arsip['tanggal_formatted'] ? $arsip['tanggal_formatted'] : ''?></td>
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
                                	<a href="<?= $current_page > 1 ? base_url('dashboard/kode-klasifikasi/detail/'.$klasifikasi['id'].'?page='.($current_page - 1).'&search='.$search.'&status='.$status.'&level='.$level.'&sort='.$sort) : '#' ?>" class="btn btn-primary"
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
                                	<a href="<?= $current_page < $total_page ? base_url('dashboard/kode-klasifikasi/detail/'.$klasifikasi['id'].'?page='.($current_page + 1).'&search='.$search.'&status='.$status.'&level='.$level.'&sort='.$sort) : '#' ?>" class="btn btn-primary"
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
                        <input id="kode-input" value="<?= $klasifikasi['kode'] ?>" type="text" class="form-control" value="">
                    </div>
    				<div class="mb-3">
                        <label for="">Nama</label>
                        <input id="nama-input" value="<?= $klasifikasi['nama'] ?>" type="text" class="form-control" value="">
                    </div>
    				<div class="mb-3">
                        <label for="">Deskripsi</label>
                        <textarea name="" id="deskripsi-textarea" rows="2" class="form-control"><?= $klasifikasi['deskripsi'] ?></textarea>
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