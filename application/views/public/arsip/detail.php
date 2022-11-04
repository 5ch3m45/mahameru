<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Arsip #<?= $arsip['nomor'] ?> | MAHAMERU</title>
    <!-- Favicon icon -->    
    <link rel="apple-touch-icon" sizes="57x57" href="/assets/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/assets/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/assets/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/assets/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- End favicon icon -->
    <!-- Custom CSS -->
    <link href="<?= assets_url() ?>/css/landingpage.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="<?= assets_url() ?>/css/custom.css?v=<?= time() ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/viewerjs/dist/viewer.css" crossorigin="anonymous">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
        />
</head>

<body>
    <div id="main-wrapper">
        <header class="py-3 bg-white">
            <div class="container">
                <!-- Start Header -->
                <div class="header">
                    <nav class="navbar navbar-expand-md navbar-light px-0">
                        <a class="navbar-brand d-flex py-0" href="/">
                            <img src="<?= assets_url() ?>/images/logo.png" alt="logo" style="max-height: 2.8rem">
                            <span class="ml-2">
                                <div class="my-auto">
                                    <p class="mb-0" style="line-height: 1.2; font-size: 1.3rem"><strong>MAHAMERU</strong></p>
                                    <p style="margin: 0; line-height: 1; font-size: .8rem; white-space: pre-wrap;">Manajemen Arsip Hasil Alih Media Baru</p>
                                </div>
                            </span>
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="nav d-flex flex-column mt-4 d-md-none justify-content-start w-100">
                        		<li class="nav-item">
                        			<a class="nav-link active" aria-current="page" href="/">
                                        <i class="mdi mdi-home"></i>
                                    </a>
                        		</li>
                        		<li class="nav-item">
                        			<a href="<?= base_url('dashboard') ?>">
                                        <button class="btn btn-primary">Upload Arsip</button>
                                    </a>
                        		</li>
                        	</ul>
                        	<ul class="nav d-none d-md-flex justify-content-end w-100">
                        		<li class="nav-item">
                        			<a class="nav-link active" aria-current="page" href="/">
                                        <i class="mdi mdi-home"></i>
                                    </a>
                        		</li>
                        		<li class="nav-item">
                        			<a href="<?= base_url('dashboard') ?>">
                                        <button class="btn btn-primary">Upload Arsip</button>
                                    </a>
                        		</li>
                        	</ul>
                        </div>
                    </nav>
                </div>
                <!-- End Header -->
            </div>
        </header>
        <div class="content-wrapper">
            <section class="spacer bg-white">
                <div class="container">
                    <div class="mb-5">
                        <h1 class="text-dark display-text">#<?= $arsip['nomor'] ?></h1>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <div class="card rounded-corner shadow">
                                <div class="card-body">
                                    <p><?= $arsip['informasi'] ?></p>
                                    <hr>
                                    <small class="text-muted">Nomor</small>
                                    <h6><?= $arsip['nomor'] ?></h6>
                                    <small class="text-muted p-t-30 db">Kode klasifikasi</small>
                                    <h6><?= $arsip['kode_klasifikasi']['kode'] ?? '-' ?>: <?= $arsip['kode_klasifikasi']['nama'] ?? '-' ?></h6>
                                    <small class="text-muted p-t-30 db">Pencipta</small>
                                    <h6><?= $arsip['pencipta'] ?></h6>
                                    <small class="text-muted p-t-30 db">Tahun Arsip</small>
                                    <h6><?= $arsip['tahun'] ?? '-' ?></h6>
                                    <small class="text-muted p-t-30 db">Dilihat sebanyak</small>
                                    <h6><?= $arsip['viewers'] ?? '0' ?>&nbsp;kali</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-9">
                            <h3>Lampiran Dokumen & Video</h3>
                            <hr>
                            <table class="table mb-5">
                                <thead>
                                    <tr>
                                        <th>Nama File</th>
                                        <th>Tipe</th>
                                        <th>Unduh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter = 0; ?>
                                    <?php foreach($arsip['lampirans'] as $key => $lampiran) { 
                                        if(!in_array($lampiran['type'], ['image/jpg', 'image/jpeg', 'image/png'])) {
                                            $counter++; ?>
                                            <tr>
                                                <?php 
                                                    $explodeURL = explode('/', $lampiran['url']); 
                                                    $fileName = end($explodeURL);
                                                    $explodeFileName = explode('-', $fileName);
                                                    array_shift($explodeFileName); // hapus first element
                                                    $finalFileName = implode('-', $explodeFileName);
                                                ?>
                                                <td style="white-space: nowrap; text-overflow: ellipsis; overflow: hidden;"><?= $finalFileName ?></td>
                                                <td><?= $lampiran['type'] ?></td>
                                                <td><a href="<?= $lampiran['url'] ?>"><i class="bi bi-cloud-arrow-down-fill"></i></a></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if($counter == 0) { ?>
                                        <tr>
                                            <td colspan="3" class="text-center">Belum ada lampiran dokumen & video</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <h3>Lampiran Foto</h3>
                            <div>
                                <ul class="docs-pictures mb-5">
                                    <?php foreach($arsip['lampirans'] as $key => $lampiran) { ?>
                                        <?php if(in_array($lampiran['type'], ['image/jpg', 'image/jpeg', 'image/png'])) { ?>
                                            <li class="d-flex justify-content-center">
                                                <img data-original="<?= $lampiran['url'] ?>" alt="img-<?= $key ?>" src="<?= $lampiran['url'] ?>" />
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="modal fade" id="lampiranDetailModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="lampiranDetailModalLabel" aria-hidden="true">
    	<div class="modal-dialog modal-dialog-centered modal-xl d-flex justify-content-center">
    		<div class="modal-content" style="width: auto">
                <div id="lampiranFile">
                    <img src="/assets/uploads/TZCVrA-Screenshot_1.png" style="max-width: 100%; max-height: 80vh">
                </div>
    			<div class="modal-body">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    </div>
    			</div>
    		</div>
    	</div>
    </div>
</body>
<script src="<?= assets_url() ?>libs/jquery/dist/jquery.min.js"></script>
<script src="<?= assets_url() ?>libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= assets_url() ?>libs/masonryGrid/jquery.masonryGrid.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="<?= assets_url() ?>js/pages/arsip/detail.js?v=<?= time() ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/viewerjs@1.11.0/dist/viewer.js"></script>
<script src="<?= assets_url() ?>libs/jquery-viewer/dist/jquery-viewer.min.js"></script>
<script type="text/javascript">
    var $images = $('.docs-pictures');
    var options = {
    	// inline: true,
    	url: 'data-original',
    	ready: function (e) {
    		console.log(e.type);
    	},
    	show: function (e) {
    		console.log(e.type);
    	},
    	shown: function (e) {
    		console.log(e.type);
    	},
    	hide: function (e) {
    		console.log(e.type);
    	},
    	hidden: function (e) {
    		console.log(e.type);
    	},
    	view: function (e) {
    		console.log(e.type);
    	},
    	viewed: function (e) {
    		console.log(e.type);
    	}
    };
    $images.on({
    	ready: function (e) {
    		console.log(e.type);
    	},
    	show: function (e) {
    		console.log(e.type);
    	},
    	shown: function (e) {
    		console.log(e.type);
    	},
    	hide: function (e) {
    		console.log(e.type);
    	},
    	hidden: function (e) {
    		console.log(e.type);
    	},
    	view: function (e) {
    		console.log(e.type);
    	},
    	viewed: function (e) {
    		console.log(e.type);
    	}
    }).viewer(options);

    $(function() {
        setTimeout(() => {
            $('.docs-pictures > li').height($('.docs-pictures > li').width());
            $('.docs-pictures > li > img').height($('.docs-pictures > li').width());
            $('.docs-pictures > li > img')
        }, 1000);
    })
</script>
</html>