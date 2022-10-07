<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Buat Kata Sandi Baru | MAHAMERU</title>
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
                                <?php if($success) { ?>
                                    <form id="reset-password-form" method="POST" class="card-body">
                                        <input type="hidden" id="csrf-token" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                        <input type="hidden" id="forgot-password-token" name="forgot_password_token" value="<?= $token ?>">
                                        <h2 class="display-text text-dark">Buat Kata Sandi Baru</h2>
                                        <p>Silahkan masukkan <span class="text-primary">kata sandi</span> baru Anda. Pastikan kata sandi baru Anda tidak mudah ditebak.</p>
                                        <hr>
                                        <div class="">
                                            <label for="">Kata Sandi Baru</label>
                                            <input type="password" name="password" id="password-input" class="form-control rounded-corner">
                                        </div>
                                        <div id="password-error" class="error-container"></div>
                                        <div class="mt-3">
                                            <label for="">Konfirmasi Kata Sandi Baru</label>
                                            <input type="password" name="password_confirm" id="confirm-password-input" class="form-control rounded-corner">
                                        </div>
                                        <div id="confirm-password-error" class="error-container"></div>
                                        <div class="my-3">
                                            <button type="submit" class="btn btn-block btn-primary">Buat Kata Sandi Baru</button>
                                        </div>
                                    </form>
                                    <div id="success-body" class="card-body" style="display: none">
                                        <div class="text-center mb-3">
                                            <span class="text-success x-large-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-fill-check" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647z"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="text-center">
                                            <p>Password berhasil diperbarui. Silahkan <a href="/login">login disini</a>.</p>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <span class="text-danger x-large-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-frown-fill" viewBox="0 0 16 16">
                                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm-2.715 5.933a.5.5 0 0 1-.183-.683A4.498 4.498 0 0 1 8 9.5a4.5 4.5 0 0 1 3.898 2.25.5.5 0 0 1-.866.5A3.498 3.498 0 0 0 8 10.5a3.498 3.498 0 0 0-3.032 1.75.5.5 0 0 1-.683.183zM10 8c-.552 0-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5S10.552 8 10 8z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="text-center">
                                        <p><?= $message ?></p>
                                    </div>
                                </div>
                                <?php } ?>
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
<script src="<?= assets_url() ?>js/pages/auth/reset-password.js?v=<?= time() ?>"></script>
</html>