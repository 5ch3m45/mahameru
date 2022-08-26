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
    <link rel="icon" type="image/png" sizes="16x16" href="<?= assets_url() ?>/images/favicon.png">
    <!-- Custom CSS -->
    <link href="<?= assets_url() ?>/css/landingpage.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="<?= assets_url() ?>/libs/gridjs/gridjs.css" rel="stylesheet" />
    <link href="<?= assets_url() ?>/css/custom.css?v=<?= time() ?>" rel="stylesheet">
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
                        			<a href="">
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
                        <h1 class="text-dark display-text">Database Arsip</h1>
                    </div>
                    <div id="datagrid" class="table-responsive"></div>
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
<script type="module">
    import { Grid, h } from "http://mahameru.test/assets/libs/gridjs/gridjs.module.js";
    new Grid({
        columns: ["Nomor", "Kode Klasifikasi", {
            name: "Uraian Informasi",
            formatter: (cell, row) => {
                return h('a', {
                        className: '',
                        href: `/arsip/${row.cells[0].data}`
                    }, cell
                )
            }
        }, {
            name: "Lampiran",
            formatter: (cell, row) => {
                // let ch = () => {
                //     console.log(cell)
                //     return cell;
                // }
                let data = JSON.parse(cell)
                let child = () => {
                    return data.map(d => {
                        if(d.type == 'image') {
                            return h('li', {
                                className: 'avatars__item'
                            }, h('img', {
                                className: 'avatars__img',
                                src: d.url
                            }))
                        } else {
                            return h('li', {
                                className: 'avatars__item'
                            }, h('span', {
                                className: 'avatars__initials'
                            }, d.text))
                        }
                    });
                }
                return h('ul', {
                    className: 'avatars',
                }, child())
            }
        }, "Pencipta", "Tahun"],
        pagination: true,
        search: true,
        sort: true,
        data: [
            ["1", "20", "Peringatan HUT Dharma Wanita ke 20", '[{"type":"image","url":"http://mahameru.test/assets/images/users/5.jpg"},{"type":"text","text":"KD"}]', "Dharma Wanita", "1994", null],
        ]
    }).render(document.getElementById("datagrid"));
</script>
</html>