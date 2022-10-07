<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Masuk Dashboard | MAHAMERU</title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?= assets_url() ?>/images/favicon.png">
    <link href="<?= assets_url() ?>/css/landingpage.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="<?= assets_url() ?>/libs/gridjs/gridjs.css" rel="stylesheet" />
    <link href="<?= assets_url() ?>/css/custom.css?v=<?= time() ?>" rel="stylesheet">
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
                                    <div class="">
                                        <label for="">Email</label>
                                        <input type="text" name="login_string" id="email-input" class="form-control rounded-corner" placeholder="Email">
                                    </div>
                                    <div id="email-error" class="mt-1 error-container"></div>
                                    <div class="mt-3">
                                        <label for="">Kata sandi</label>
                                        <input type="password" name="login_pass" id="password-input" class="form-control rounded-corner" placeholder="Kata sandi">
                                    </div>
                                    <div id="password-error" class="mt-1 error-container"></div>
                                    <div class="mt-3">
                                        <label for="">Verifikasi</label>
                                        <div class="mb-2">
                                            <img id="captcha-image" src="<?= $captcha ?>" alt="">
                                        </div>
                                        <input id="captcha-input" name="captcha" type="text" class="form-control" placeholder="Verifikasi">
                                    </div>
                                    <div id="captcha-error" class="mt-1 error-container"></div>
                                    <div class="mt-4 mb-3">
                                        <button type="submit" class="btn btn-block btn-primary">Sign In</button>
                                    </div>
                                    <p class="mb-0">Lupa kata sandi? <a href="<?= base_url('forgot-password') ?>">Perbarui kata sandi.</a></p>
                                </form>
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