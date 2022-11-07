<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Database Arsip | MAHAMERU</title>
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
    <link href="<?= assets_url() ?>/css/landingpage.css?v=<?= time() ?>" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="<?= assets_url() ?>/css/custom.css?v=<?= time() ?>" rel="stylesheet">
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
                        <h1 class="text-dark display-text">Database Arsip</h1>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-3">
                            <label for="search-input">Cari:</label>
                            <input id="search-input" name="search" type="text" placeholder="Ketik untuk mencari.." class="form-control rounded-lg" value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="sort-input">Urutkan:</label>
                            <select name="sort" id="sort-input" class="form-control rounded-lg">
                                <option value="terbaru">Terbaru</option>
                                <option value="terlama">Terlama</option>
                            </select>
                        </div>
                        <div class="col d-flex align-items-end">
                            <button id="reset-table" class="btn btn-light shadow-sm"><i class="bi bi-arrow-clockwise"></i> Reset</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="arsip-table" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Kode Klasifikasi</th>
                                    <th>Uraian Informasi</th>
                                    <th>Lampiran</th>
                                    <th>Pencipta</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                    	<button id="prev-page" class="btn btn-primary" style="border-radius: 10px 0 0 10px">Sebelumnya</button>
                        <div class="input-group" style="width: auto">
                            <span class="input-group-text" style="border-radius: 0!important">Halaman</span>
                            <input type="text" id="current-page" value="1" style="max-width: 3rem; padding: 0 10px; border-radius: 0!important">
                            <span class="input-group-text" id="total-page" style="border-radius: 0px!important">dari 10</span>
                        </div>
                    	<button id="next-page" class="btn btn-primary" style="border-radius: 0 10px 10px 0">Selanjutnya</button>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
<script src="<?= assets_url() ?>libs/jquery/dist/jquery.min.js"></script>
<script src="<?= assets_url() ?>libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="<?= assets_url() ?>js/app.js?v=<?= time() ?>"></script>
<script src="<?= assets_url() ?>js/pages/arsip/index.js?v=<?= time() ?>"></script>
</html>