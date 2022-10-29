<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Artikel | MAHAMERU</title>
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
    <link href="<?= assets_url() ?>/libs/gridjs/gridjs.css" rel="stylesheet" />
    <link href="<?= assets_url() ?>/css/custom.css" rel="stylesheet">
    <style>
        html, body {
            background-color: #fff;
            scroll-behavior: smooth;
        }
        .display-text {
            font-family: 'Montserrat', sans-serif;
            color: #000!important
        }
        p {
            color: #000
        }
        .text-grey {
            color: var(--grey)
        }

        #today-archive .description {
            background-image: linear-gradient(180deg,#000000 0%,rgba(0,0,0,0));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- Main wrapper -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Header part -->
        <!-- ============================================================== -->
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
                        			<a href="">
                                        <button class="btn btn-primary">Upload Artikel</button>
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
                        			<a href="">
                                        <button class="btn btn-primary">Upload Artikel</button>
                                    </a>
                        		</li>
                        	</ul>
                        </div>
                    </nav>
                </div>
                <!-- End Header -->
            </div>
        </header>
        <!-- ============================================================== -->
        <!-- Header part -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper part -->
        <!-- ============================================================== -->
        <div class="content-wrapper">
            <!-- ============================================================== -->
            <!-- Demos part -->
            <!-- ============================================================== -->
            <section class="spacer bg-white">
                <div class="container">
                    <div class="mb-5">
                        <h1 class="text-dark display-text">Artikel</h1>
                    </div>
                    <div class="row">
                        <div class="col-9">
                            <div class="row">
                                <div class="col-6 mb-4">
                                    <div class="article-card card shadow rounded-corner" role="button" data-id="1" style="height:500px">
                                        <div class="rounded-corner-card-image" style="height: 300px; background-image: url('https://images.unsplash.com/photo-1660562924547-71ba91ccc4b6?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw0OHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60'); background-position: center; background-size: cover"></div>
                                        <div class="card-body" style="font-size: .8rem; max-height: 200px;">
                                            <div class="description" style="max-height: 100%; overflow: hidden; text-overflow: ellipsis;">
                                                <small>26/7/98</small><br>
                                                <strong>Lorem Ipsum</strong>
                                                <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem beatae iste perspiciatis labore veniam asperiores, delectus ratione magnam in non. Molestias perspiciatis saepe dolorem illum, adipisci ea nesciunt quam suscipit.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-4">
                                    <div class="article-card card shadow rounded-corner" role="button" data-id="1" style="height:500px">
                                        <div class="rounded-corner-card-image" style="height: 300px; background-image: url('https://images.unsplash.com/photo-1660562924547-71ba91ccc4b6?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw0OHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60'); background-position: center; background-size: cover"></div>
                                        <div class="card-body" style="font-size: .8rem; max-height: 200px;">
                                            <div class="description" style="max-height: 100%; overflow: hidden; text-overflow: ellipsis;">
                                                <small>26/7/98</small><br>
                                                <strong>Lorem Ipsum</strong>
                                                <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem beatae iste perspiciatis labore veniam asperiores, delectus ratione magnam in non. Molestias perspiciatis saepe dolorem illum, adipisci ea nesciunt quam suscipit.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-4">
                                    <div class="article-card card shadow rounded-corner" role="button" data-id="1" style="height:500px">
                                        <div class="rounded-corner-card-image" style="height: 300px; background-image: url('https://images.unsplash.com/photo-1660562924547-71ba91ccc4b6?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw0OHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60'); background-position: center; background-size: cover"></div>
                                        <div class="card-body" style="font-size: .8rem; max-height: 200px;">
                                            <div class="description" style="max-height: 100%; overflow: hidden; text-overflow: ellipsis;">
                                                <small>26/7/98</small><br>
                                                <strong>Lorem Ipsum</strong>
                                                <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem beatae iste perspiciatis labore veniam asperiores, delectus ratione magnam in non. Molestias perspiciatis saepe dolorem illum, adipisci ea nesciunt quam suscipit.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-4">
                                    <div class="article-card card shadow rounded-corner" role="button" data-id="1" style="height:500px">
                                        <div class="rounded-corner-card-image" style="height: 300px; background-image: url('https://images.unsplash.com/photo-1660562924547-71ba91ccc4b6?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw0OHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60'); background-position: center; background-size: cover"></div>
                                        <div class="card-body" style="font-size: .8rem; max-height: 200px;">
                                            <div class="description" style="max-height: 100%; overflow: hidden; text-overflow: ellipsis;">
                                                <small>26/7/98</small><br>
                                                <strong>Lorem Ipsum</strong>
                                                <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem beatae iste perspiciatis labore veniam asperiores, delectus ratione magnam in non. Molestias perspiciatis saepe dolorem illum, adipisci ea nesciunt quam suscipit.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-4">
                                    <div class="article-card card shadow rounded-corner" role="button" data-id="1" style="height:500px">
                                        <div class="rounded-corner-card-image" style="height: 300px; background-image: url('https://images.unsplash.com/photo-1660562924547-71ba91ccc4b6?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw0OHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60'); background-position: center; background-size: cover"></div>
                                        <div class="card-body" style="font-size: .8rem; max-height: 200px;">
                                            <div class="description" style="max-height: 100%; overflow: hidden; text-overflow: ellipsis;">
                                                <small>26/7/98</small><br>
                                                <strong>Lorem Ipsum</strong>
                                                <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem beatae iste perspiciatis labore veniam asperiores, delectus ratione magnam in non. Molestias perspiciatis saepe dolorem illum, adipisci ea nesciunt quam suscipit.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-4">
                                    <div class="article-card card shadow rounded-corner" role="button" data-id="1" style="height:500px">
                                        <div class="rounded-corner-card-image" style="height: 300px; background-image: url('https://images.unsplash.com/photo-1660562924547-71ba91ccc4b6?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw0OHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60'); background-position: center; background-size: cover"></div>
                                        <div class="card-body" style="font-size: .8rem; max-height: 200px;">
                                            <div class="description" style="max-height: 100%; overflow: hidden; text-overflow: ellipsis;">
                                                <small>26/7/98</small><br>
                                                <strong>Lorem Ipsum</strong>
                                                <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem beatae iste perspiciatis labore veniam asperiores, delectus ratione magnam in non. Molestias perspiciatis saepe dolorem illum, adipisci ea nesciunt quam suscipit.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-4">
                                    <div class="article-card card shadow rounded-corner" role="button" data-id="1" style="height:500px">
                                        <div class="rounded-corner-card-image" style="height: 300px; background-image: url('https://images.unsplash.com/photo-1660562924547-71ba91ccc4b6?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw0OHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60'); background-position: center; background-size: cover"></div>
                                        <div class="card-body" style="font-size: .8rem; max-height: 200px;">
                                            <div class="description" style="max-height: 100%; overflow: hidden; text-overflow: ellipsis;">
                                                <small>26/7/98</small><br>
                                                <strong>Lorem Ipsum</strong>
                                                <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem beatae iste perspiciatis labore veniam asperiores, delectus ratione magnam in non. Molestias perspiciatis saepe dolorem illum, adipisci ea nesciunt quam suscipit.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="shadow p-2 rounded-corner">
                                <input type="text" name="" id="" class="form-control rounded-corner" placeholder="Cari artikel">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- ============================================================== -->
        <!-- End page wrapperHeader part -->
        <!-- ============================================================== -->
        <footer class="text-center p-4"> All Rights Reserved by Flexy Admin. Designed and Developed by <a
                href="https://www.wrappixel.com">WrapPixel</a>. Illustration by <a href="https://icons8.com/illustrations/author/zD2oqC8lLBBA">Icons 8</a> from <a href="https://icons8.com/illustrations">Ouch!</a></footer>
    </div>
</body>
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="<?= assets_url() ?>libs/jquery/dist/jquery.min.js"></script>
<script src="<?= assets_url() ?>libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= assets_url() ?>libs/gridjs/gridjs.umd.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.article-card', function() {
            window.location.href = `/artikel/${$(this).data('id')}`
        })
    })
</script>
</html>