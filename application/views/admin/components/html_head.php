<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Flexy lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Flexy admin lite design, Flexy admin lite dashboard bootstrap 5 dashboard template">
    <meta name="description" content="Flexy Admin Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="token_name" content="<?= $this->security->get_csrf_token_name() ?>">
    <meta name="token_hash" content="<?= $this->security->get_csrf_hash() ?>">
    <meta name="robots" content="noindex,nofollow">
    <title><?= @$title ? $title.' | MAHAMERU' : 'MAHAMERU' ?></title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/Flexy-admin-lite/" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?= assets_url() ?>images/favicon.png">
    <link href="<?= assets_url() ?>libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="<?= assets_url() ?>libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <link href="<?= assets_url() ?>libs/dropzone/dropzone.min.css" rel="stylesheet">
    <link href="<?= assets_url() ?>libs/select2-4.0.13/css/select2.min.css" rel="stylesheet">
    <link href="<?= assets_url() ?>libs/select2-4.0.13/css/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    <link href="<?= assets_url() ?>css/style.min.css?v=<?= time() ?>" rel="stylesheet">
    <style>
        ul.avatars {
            display: flex ; /* Causes LI items to display in row. */
            list-style-type: none ;
            margin: auto ; /* Centers vertically / horizontally in flex container. */
            padding: 0px 7px 0px 0px ;
            z-index: 1 ; /* Sets up new stack-container. */
        }
        li.avatars__item {
            height: 49px ;
            margin: 0px 0px 0px -10px ;
            padding: 0px 0px 0px 0px ;
            position: relative ;
            width: 42px ; /* Forces flex items to be smaller than their contents. */
        }
        li.avatars__item:nth-child( 1 ) { z-index: 9 ; }
        li.avatars__item:nth-child( 2 ) { z-index: 8 ; }
        li.avatars__item:nth-child( 3 ) { z-index: 7 ; }
        li.avatars__item:nth-child( 4 ) { z-index: 6 ; }
        li.avatars__item:nth-child( 5 ) { z-index: 5 ; }
        li.avatars__item:nth-child( 6 ) { z-index: 4 ; }
        li.avatars__item:nth-child( 7 ) { z-index: 3 ; }
        li.avatars__item:nth-child( 8 ) { z-index: 2 ; }
        li.avatars__item:nth-child( 9 ) { z-index: 1 ; }
        img.avatars__img,
        span.avatars__initials,
        span.avatars__others {
            background-color: #596376 ;
            border: 0px solid #fff ;
            box-shadow: 0px 0px 3px #777;
            border-radius: 100px 100px 100px 100px ;
            color: #FFFFFF ;
            display: block ;
            font-family: sans-serif ;
            font-size: 12px ;
            font-weight: 100 ;
            height: 45px ;
            line-height: 45px ;
            text-align: center ;
            width: 45px ;
        }
        img.avatars__img.no-shadow {
            box-shadow: 0px 0px 0px;
        }
        span.avatars__others {
            background-color: #1E8FE1 ;
        }
        .dropzone {
            min-height: 150px;
            border: 1px solid rgba(0,0,0,.06);
            background: #fff;
            padding: 20px 20px;
            border-radius: 20px;
        }
        .error-text p {
            font-size: .8rem;
            color: red;
            margin-top: .5rem
        }
        p, label, small, h1, h2, h3, h4, h5, h6 {
            color: black
        }
        .grid-sizer,
        .grid-item { width: 50%; padding: 5px }
        .ct-label.ct-label.ct-horizontal.ct-end {
            position: relative;
            justify-content: flex-end;
            text-align: right;
            transform-origin: 100% 0;
            transform: translate(-100%) rotate(-45deg);
            white-space:nowrap;
        }
    </style>
</head>