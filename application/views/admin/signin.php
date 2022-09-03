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
                    </nav>
                </div>
            </div>
        </header>
        <div class="content-wrapper">
            <section class="spacer bg-white">
                <div class="container">
                    <div class="row mb-5">
                        <div class="col-6">
                            <img src="<?= assets_url() ?>images/example-29.svg" style="width: 100%" alt="" srcset="">
                        </div>
                        <div class="col-6">
                            <div class="card rounded-corner shadow">
                                <form id="signin-form" method="POST" class="card-body">
                                    <input type="hidden" id="csrf-token" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                    <h2 class="display-text text-dark">Sign In</h2>
                                    <p>Silahkan masukkan <span class="text-primary">email</span> dan <span class="text-primary">kata sandi</span> Anda untuk masuk ke dashboard.</p>
                                    <hr>
                                    <div class="mb-3">
                                        <label for="">Email</label>
                                        <input type="text" name="login_string" id="email-input" class="form-control rounded-corner">
                                    </div>
                                    <div class="mb-4">
                                        <label for="">Kata sandi</label>
                                        <input type="password" name="login_pass" id="password-input" class="form-control rounded-corner">
                                    </div>
                                    <div class="mb-3">
                                        <div id="login-error" class="mb-3"></div>
                                        <button type="submit" class="btn btn-block btn-primary">Sign In</button>
                                    </div>
                                    <p class="mb-0">Lupa kata sandi? <a href="">Hubungi Admin</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="<?= assets_url() ?>libs/jquery/dist/jquery.min.js"></script>
<script src="<?= assets_url() ?>libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="<?= assets_url() ?>js/pages/auth/signin.js?v=<?= time() ?>"></script>
</html>