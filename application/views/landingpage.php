<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Selamat Datang | MAHAMERU</title>
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
    <meta name="token_name" content="<?= $this->security->get_csrf_token_name() ?>">
    <meta name="token_hash" content="<?= $this->security->get_csrf_hash() ?>">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="<?= assets_url() ?>/css/landingpage.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.2.0/css/glide.core.min.css" integrity="sha512-YQlbvfX5C6Ym6fTUSZ9GZpyB3F92hmQAZTO5YjciedwAaGRI9ccNs4iw2QTCJiSPheUQZomZKHQtuwbHkA9lgw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.2.0/css/glide.theme.min.css" integrity="sha512-wCwx+DYp8LDIaTem/rpXubV/C1WiNRsEVqoztV0NZm8tiTvsUeSlA/Uz02VTGSiqfzAHD4RnqVoevMcRZgYEcQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="<?= assets_url() ?>/css/custom.css" rel="stylesheet">
</head>

<body>
    <div class="modal fade rounded-corner" id="aduanModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="aduanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered rounded-corner">
            <div class="modal-content rounded-corner">
                <div class="modal-body">
                    <div id="aduan-modal-body"></div>
                    <div class="pt-4 d-flex justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="main-wrapper">
        <header class="py-3 bg-white">
            <div class="container">
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
                        			<a class="nav-link active" aria-current="page" href="#">
                                        <i class="mdi mdi-home"></i>
                                    </a>
                        		</li>
                        		<li class="nav-item">
                        			<a class="nav-link" href="#pencarian">Pencarian</a>
                        		</li>
                        		<!-- <li class="nav-item">
                        			<a class="nav-link" href="#artikel-pilihan">Artikel Pilihan</a>
                        		</li> -->
                        		<li class="nav-item">
                        			<a class="nav-link" href="#arsip-hari-ini">Arsip Hari Ini</a>
                        		</li>
                        		<li class="nav-item">
                        			<a href="/dashboard">
                                        <button class="btn btn-primary">Upload Arsip</button>
                                    </a>
                        		</li>
                        	</ul>
                        	<ul class="nav d-none d-md-flex justify-content-end w-100">
                        		<li class="nav-item">
                        			<a class="nav-link active" aria-current="page" href="#">
                                        <i class="mdi mdi-home"></i>
                                    </a>
                        		</li>
                        		<li class="nav-item">
                        			<a class="nav-link" href="#pencarian">Pencarian</a>
                        		</li>
                        		<!-- <li class="nav-item">
                        			<a class="nav-link" href="#artikel-pilihan">Artikel Pilihan</a>
                        		</li> -->
                        		<li class="nav-item">
                        			<a class="nav-link" href="#arsip-hari-ini">Arsip Hari Ini</a>
                        		</li>
                        		<li class="nav-item">
                        			<a href="/dashboard">
                                        <button class="btn btn-primary">Upload Arsip</button>
                                    </a>
                        		</li>
                        	</ul>
                        </div>
                    </nav>
                </div>
            </div>
        </header>
        <div class="content-wrapper">
            <section id="home" class="spacer bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-7 order-2 order-md-1 d-flex align-items-center">
                            <div>
                                <h1 class="text-dark display-text animate__animated animate__fadeInUp">Tanpa <span class="text-primary">arsip</span>, banyak cerita akan hilang.</h1>
                                <p style="font-size: 1.3rem" class="text-grey mb-4 animate__animated animate__fadeInUp animate__delay-1s">— Sara Sheridan (penulis)</p>
                                <p class="animate__animated animate__fadeInUp animate__delay-2s">Platform ini digunakan untuk menyimpan dan mengelola arsip hasil digitalisasi berupa foto, video ataupun dokumen dari arsip fisik.</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-5 order-1 order-md-2 mb-4 mb-lg-0 d-flex justify-content-end">
                            <img src="<?= assets_url() ?>/images/archive.png" class="animate__animated animate__fadeInRight animate__slower" style="max-height: 400px; max-width : 100%" alt="">
                        </div>
                    </div>
                </div>
            </section>
            <section id="pencarian" class="spacer bg-white">
                <div class="container">
                    <div style="box-shadow: 0px 0px 20px #bbb; border-radius: 50px" data-aos="zoom-in" class="search-section p-2 d-none d-md-block animate__animated animate__fadeIn animate__slower">
                        <div class="d-flex">
                            <input type="text" name="" id="" class="search-arsip form-control form-control-lg input-landing" style="border: 0px"  placeholder="Cari arsip">
                            <!-- <div class="mr-2" style="border: 0px; background-color: var(--primary); min-width: 170px; color: white; border-radius: 20px; padding-right: 1rem">
                                <select name="" id="" class="form-control form-control-lg select-landing" style="border: 0px; background-color: var(--primary); color: white; border-radius: 20px;">
                                    <option value="">Jenis Arsip</option>
                                    <option value="">Dokumen</option>
                                    <option value="">Foto</option>
                                    <option value="">Video</option>
                                </select>
                            </div> -->
                            <button type="button" class="btn btn-primary search-go" style="border-radius: 50px">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                        </div>
                    </div>
                    <div data-aos="zoom-in-up" class="search-section d-block d-md-none animate__animated animate__fadeIn">
                        <input type="text" name="" class="search-arsip form-control form-control-lg mb-2" style="border: 0px; box-shadow: 0px 0px 20px #bbb; border-radius: 50px"  placeholder="Cari arsip">
                        <!-- <div class="mb-2" style="border: 0px; background-color: var(--primary); min-width: 170px; color: white; border-radius: 20px; padding-right: 1rem">
                            <select name="" id="" class="form-control form-control-lg" style="border: 0px; background-color: var(--primary); color: white; border-radius: 20px;">
                                <option value="">Jenis Arsip</option>
                                <option value="">Dokumen</option>
                                <option value="">Foto</option>
                                <option value="">Video</option>
                            </select>
                        </div> -->
                        <button type="button" class="search-go btn btn-primary btn-block" style="border-radius: 50px">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>
                </div>
            </section>
            <!-- <section id="artikel-pilihan" class="spacer bg-white">
                <div class="container">
                    <div class="d-md-flex d-block">
                        <div class="mr-4">
                            <img src="<?= assets_url() ?>/images/business-3d-old-man-standing-with-coat-on-hand.png" style="max-height: 300px; max-width: 300px" alt="" srcset="">
                        </div>
                        <div>
                            <h1 class="text-dark display-text">Lorem ipsum dolor sit amet consectetur adipisicing elit.</h1>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt ducimus minima nulla ipsam exercitationem perspiciatis nihil ex quis tenetur, aperiam odio? Ad reiciendis quos, libero itaque aliquid fugiat molestias consequuntur eligendi perspiciatis veritatis. Aperiam corporis, dolor recusandae est aspernatur dolorum consectetur culpa odio esse praesentium corrupti reiciendis aliquam totam quis?</p>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Velit corporis, rerum, fuga eligendi eos, voluptates ipsam adipisci culpa impedit tempora vitae ullam repellat ex deserunt commodi delectus blanditiis iusto accusamus labore iure? Minus aliquam facere earum, corrupti aspernatur fuga soluta magni beatae sapiente, quia, perspiciatis aperiam nemo delectus excepturi cum?</p>
                            <a href="/artikel/1">Baca selengkapnya</a> | <a href="/artikel"><button class="btn btn-sm btn-primary">Artikel Lainnya</button></a>
                        </div>
                    </div>
                </div>
            </section> -->
            <section id="arsip-hari-ini" class="spacer bg-white">
                <div class="container">
                    <div class="d-md-flex d-block justify-content-between mb-5">
                        <div>
                            <p class="mb-0">ARSIP</p>
                            <h2 class="text-dark display-text">HARI INI</h2>
                        </div>
                        <div class="d-flex align-items-end">
                            <?php if($arsip_hari_ini) { ?>
                                <a href="/arsip">
                                    <button class="btn btn-sm btn-primary">Lebih banyak arsip</button>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if($arsip_hari_ini) { ?>
                    <div id="today-archive">
                        <div id="intro" class="glide">
                        	<div class="glide__track" data-glide-el="track">
                        		<ul class="glide__slides"  style="height:380px">
                                    <?php foreach ($arsip_hari_ini as $key => $value) { ?>
                                        <li class="glide__slide">
                                            <div class="today-archive-card card rounded-corner shadow" role="button" data-id="<?= $value['id'] ?>" style="height:360px">
                                                <div class="rounded-corner-card-image" style="height: 260px; background-image: url('<?= $value['lampiran'] ? $value['lampiran']['url'] : '/assets/images/no-img.png' ?>'); background-position: center; background-size: cover"></div>
                                                <div class="card-body" style="font-size: .8rem; max-height: 120px;">
                                                    <div class="description" style="max-height: 100%; overflow: hidden; text-overflow: ellipsis;">
                                                        <small><?= $value['tanggal_formatted'] ?></small><br>
                                                        <strong><?= $value['klasifikasi']['kode'] ?>: <?= $value['klasifikasi']['nama'] ?></strong>
                                                        <p class="mb-0"><?= $value['informasi'] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                        		</ul>
                        	</div>
                        </div>
                    </div>
                    <?php } else { ?>
                        <div class="text-center">
                            <img src="/assets/images/undraw_no_data_re_kwbl.svg" class="mb-3" style="max-height: 200px;" alt="">
                            <p>
                                Tidak ada arsip hari ini. Telusuri semua arsip?
                            </p>
                            <a href="<?= base_url('arsip') ?>">
                                <button class="btn btn-primary"><i class="bi bi-search"></i> Telusuri</button>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </section>
            <section id="kolom-aduan" class="spacer bg-white">
                <div class="container">
                    <div class="d-md-flex d-block justify-content-between mb-5">
                        <div>
                            <p class="mb-0">KOLOM</p>
                            <h2 class="text-dark display-text">ADUAN</h2>
                        </div>
                        <div class="d-flex align-items-end">
                            <a href="/aduan">
                                <button class="btn btn-sm btn-primary">Periksa Aduan Anda</button>
                            </a>
                        </div>
                    </div>
                    <form id="aduan-form" action="/api/aduan/create" method="post">
                        <div class="mb-3">
                            <label for="">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email-aduan-input" placeholder="Email">
                            <small id="email-error" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label for="">Nama<span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama-aduan-input" class="form-control" placeholder="Nama">
                            <small id="nama-error" class="text-danger"></small>
                        </div>
                        <div class="mb-4">
                            <label for="">Aduan<span class="text-danger">*</span></label>
                            <textarea name="aduan" id="aduan-textarea" rows="4" class="form-control" placeholder="Aduan"></textarea>
                            <div class="d-flex justify-content-between">
                                <small>Minimal 100 karakter</small>
                                <div id="aduan-counter" class="d-flex justify-content-end" style="font-size: .8rem; color: #666">0 karakter</div>
                            </div>
                            <small id="aduan-error" class="text-danger"></small>
                        </div>
                        <div class="mb-4">
                            <label for="">Verifikasi<span class="text-danger">*</span></label>
                            <div class="mb-2">
                                <img id="captcha-image" src="<?= $captcha ?>" alt="">
                            </div>
                            <input id="captcha" name="captcha" type="text" class="form-control mb-2" placeholder="Verifikasi">
                            <small id="captcha-error" class="text-danger"></small>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Buat Aduan</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script>
        const IS_GLIDE = <?= count($arsip_hari_ini) ?>;
    </script>
    <script type="module">
        import Glide, { Autoplay, Controls, Swipe } from "https://unpkg.com/@glidejs/glide@3.2.3/dist/glide.modular.esm.js";

        if(IS_GLIDE > 0) {
            new Glide('#intro', {
                type: 'slider',
                perView: 4,
                focusAt: 'center',
                breakpoints: {
                    1024: {
                        preview: 3
                    },
                    800: {
                        perView: 2
                    },
                    480: {
                        perView: 1
                    }
                },
                autoplay: true,
            }).mount({
                Autoplay,
                Controls,
                Swipe
            })
        }
    </script>
    <script src="<?= assets_url() ?>libs/jquery/dist/jquery.min.js"></script>
    <script src="<?= assets_url() ?>libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/@glidejs/glide@3.2.3/dist/glide.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="<?= assets_url() ?>js/pages/landingpage.js?v=<?= time() ?>"></script>
</body>
</html>