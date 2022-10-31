<!DOCTYPE html>
<html dir="ltr" lang="en">

<?php include_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'html_head.php'); ?>

<body>
    <?php include_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'preloader.php'); ?>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
    	data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
    	<?php include_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'top_bar.php'); ?>
    	<?php include_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'left_sidebar.php'); ?>
    	<div class="page-wrapper">
    		<div class="page-breadcrumb">
    			<div class="row align-items-center">
    				<div class="col-6">
    					<nav aria-label="breadcrumb">
    						<ol class="breadcrumb mb-0 d-flex align-items-center">
    							<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>" class="link"><i
    										class="mdi mdi-home-outline fs-4"></i></a></li>
    							<li class="breadcrumb-item"><a href="<?= base_url('dashboard/pengelola') ?>"
    									class="link">Pengelola</a></li>
    							<li id="admin-nama-breadcrumb" class="breadcrumb-item active" aria-current="page"><image src="/assets/images/loader/loading.svg"/></li>
    						</ol>
    					</nav>
    				</div>
    				<div class="col-6">
    					<div class="text-end upgrade-btn">
    						<a href="<?= base_url('dashboard/pengelola') ?>" class="btn btn-primary text-white">
    							<i class="mdi mdi-arrow-left"></i>
    							Kembali
    						</a>
    					</div>
    				</div>
    			</div>
    		</div>
    		<div class="container-fluid">
				<div class="mb-4 d-flex flex-row">
					<button id="ubah-otoritas-menu-btn" class="btn btn-primary"><i class="bi bi-person-badge-fill"></i> Ubah Otoritas</button>
					<button id="nonaktif-menu-btn" class="btn btn-danger text-light ms-2" style="display: none;"><i class="bi bi-trash-fill"></i> Nonaktifkan</button>
					<button id="aktif-menu-btn" class="btn btn-success text-light ms-2" style="display: none;"><i class="bi bi-trash-fill"></i> Aktifkan</button>
				</div>
    			<div class="row d-flex align-items-stretch">
    				<div class="col-lg-4 col-xl-3 col-md-5">
    					<div class="card">
    						<div class="card-body">
    							<div class="text-center mb-4">
    								<img src="http://mahameru.test/assets/images/users/5.jpg" alt="user" width="100"
    									class="rounded-circle">
    								<h1 id="admin-nama-title" class="mb-0 fw-bold me-2"><image src="/assets/images/loader/loading.svg"/></h1>
    							</div>

    							<small class="text-muted p-t-30 db">Status</small>
    							<h6 id="admin-status"><image src="/assets/images/loader/loading.svg"/></h6>
    							<small class="text-muted p-t-30 db">Email</small>
    							<h6 id="admin-email"><image src="/assets/images/loader/loading.svg"/></h6>
    							<small class="text-muted p-t-30 db">Arsip Dikelola</small>
    							<h6 id="admin-arsip-count"><image src="/assets/images/loader/loading.svg"/></h6>
    							<small class="text-muted p-t-30 db">Terakhir login</small>
    							<h6 id="admin-last-login"><image src="/assets/images/loader/loading.svg"/></h6>
								<small>Otoritas</small>
								<div id="admin-otoritas"><image src="/assets/images/loader/loading.svg"/></div>
    						</div>
    					</div>
    				</div>
    				<div class="col-lg-8 col-xlg-9 col-md-7">
    					<div class="card mb-0">
    						<div class="card-body">
							<div class="row mb-4">
                                    <div class="col-12 col-md-3">
                                        <label for="search-table">Cari</label>
                                        <input type="text" name="search" id="search-table" class="form-control" placeholder="Cari">
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label for="status-table">Status</label>
                                        <select name="status" id="status-table" class="form-control">
                                            <option value="semua">Semua</option>
                                            <option value="1">Draft</option>
                                            <option value="2">Publikasi</option>
                                            <option value="3">Dihapus</option>
                                        </select>
                                    </div>
									<?php if($this->myrole->is('arsip_semua')) { ?>
                                    <div class="col-12 col-md-3">
                                        <label for="level-table">Level</label>
                                        <select name="level" id="level-table" class="form-control">
                                            <option value="semua">Semua</option>
                                            <option value="2">Publik</option>
                                            <option value="1">Rahasia</option>
                                        </select>
                                    </div>
									<?php } ?>
                                    <div class="col-12 col-md-3">
                                        <label for="sort-table">Urutkan</label>
                                        <select name="sort" id="sort-table" class="form-control">
                                            <option value="terbaru">Terbaru</option>
                                            <option value="terlama">Terlama</option>
                                            <option value="nomor">Nomor</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- title -->
                                <div class="table-responsive">
                                    <table id="arsip-table" class="table mb-4 table-hover align-middle text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">No</th>
                                                <th class="border-top-0">Kode Klasifikasi</th>
                                                <th class="border-top-0">Uraian Informasi</th>
                                                <th class="border-top-0">Lampiran</th>
                                                <th class="border-top-0">Pencipta</th>
                                                <th class="border-top-0">Tanggal</th>
                                                <th class="border-top-0">Status</th>
                                                <th class="border-top-0">Level</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<tr><td colspan="8" class="text-center"><image src="/assets/images/loader/loading.svg"/></td></tr>
										</tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" id="prev-table" class="btn btn-primary me-2">Sebelumnya</button>
                                    <button type="button" id="next-table" class="btn btn-primary">Selanjutnya</button>
                                </div>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    	<div class="modal fade" id="lampiranDetailModal" data-bs-backdrop="static" data-bs-keyboard="false"
    		tabindex="-1" aria-labelledby="lampiranDetailModalLabel" aria-hidden="true">
    		<div class="modal-dialog modal-dialog-centered d-flex justify-content-center">
    			<div class="modal-content" style="width: auto">
    				<div id="lampiranFile"></div>
    				<div class="modal-body">
    					<div class="d-flex justify-content-end">
    						<button id="hapusLampiranBtn" data-id="" type="button"
    							class="btn btn-danger text-white me-2">Hapus</button>
    						<button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
		
		<div class="modal fade rounded-corner" id="ubahOtoritasModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="ubahOtoritasModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content rounded-corner">
					<div class="modal-header rounded-corner">
						<h5 class="modal-title" id="pengelolaBaruModalLabel">Ubah Otoritas Pengelola</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form id="ubah-otoritas-form" action="/api/dashboard/admin/<?= $admin['id'] ?>/otoritas" method="post" class="modal-body rounded-corner">
						<div class="mb-3">
							<small><strong>Pengelola</strong></small>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="otoritas-pengelola">
								<label class="form-check-label" for="otoritas-pengelola">
									Mengelola Pengelola
								</label>
							</div>
							<small><strong>Arsip</strong></small>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="otoritas_arsip" id="otoritas-arsip-publik" checked>
								<label class="form-check-label" for="otoritas-arsip-publik">
									Mengelola hanya arsip publik
								</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="otoritas_arsip" id="otoritas-arsip-rahasia" >
								<label class="form-check-label" for="otoritas-arsip-rahasia">
									Mengelola semua arsip (publik dan rahasia)
								</label>
							</div>
							<small><strong>Klasifikasi</strong></small>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="otoritas-klasifikasi">
								<label class="form-check-label" for="otoritas-klasifikasi">
									Mengelola klasifikasi
								</label>
							</div>
							<small><strong>Aduan</strong></small>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="otoritas-aduan">
								<label class="form-check-label" for="otoritas-aduan">
									Mengelola aduan
								</label>
							</div>
							<div id="emailError"></div>
						</div>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
							<button id="submitKodeBtn" type="submit" class="btn btn-primary">Simpan</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade rounded-corner" id="nonaktifModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="nonaktifModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content rounded-corner">
					<div class="modal-header rounded-corner">
						<h5 class="modal-title" id="nonaktifLabel">Nonaktifkan Pengelola</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form id="nonaktif-form" action="/api/dashboard/admin/<?= $admin['id'] ?>/nonaktif" method="post" class="modal-body rounded-corner">
						<div class="mb-3">
							<p>Apakah Anda yakin untuk menonaktifkan pengelola?</p>
						</div>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
							<button type="submit" class="btn btn-danger text-light">Yakin</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade rounded-corner" id="aktifModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="aktifModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content rounded-corner">
					<div class="modal-header rounded-corner">
						<h5 class="modal-title" id="aktifLabel">Aktifkan Pengelola</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form id="aktif-form" action="/api/dashboard/admin/<?= $admin['id'] ?>/aktif" method="post" class="modal-body rounded-corner">
						<div class="mb-3">
							<p>Apakah Anda yakin untuk mengaktifkan pengelola?</p>
						</div>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
							<button type="submit" class="btn btn-success text-light">Yakin</button>
						</div>
					</form>
				</div>
			</div>
		</div>

    <?php include_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'base_js.php'); ?>
    <script src="<?= assets_url() ?>js/pages/admin/pengelola/detail.js?v=<?= time() ?>"></script>
</body>

</html>