<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Freebie 28 - SaaS Landing by pixelcave</title>

    <meta name="description" content="Freebie 28 - SaaS Landing. Check out more at https://pixelcave.com">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <!-- Icons -->
    <!-- <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
        <link rel="apple-touch-icon" href="assets/media/favicons/apple-touch-icon-180x180.png">
        <link rel="icon" href="assets/media/favicons/favicon-192x192.png"> -->
    <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">
    <link rel="icon" href="{{ asset('images/logo.png') }}"">

    {{-- <img class="img-fluid img-clip-overlay" src="{{ asset('media/various/hero-image.jpg') }}" srcset="{{ asset('media/various/hero-image@2x.jpg') }} 2x" alt="Hero Image"> --}}
    @vite('resources/css/app.css')

    <!-- Stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.1/css/all.css" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="{{ asset('css/main.css') }}"> --}}
    <style>
        /*!
        * freebie_28_saas_landing - v1.0.0
        * @author pixelcave
        * Copyright (c) 2019
        */
        html,
        body {
            font-family: 'Nunito Sans';
            background: #f6f7ff;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6 {
            font-family: 'Nunito Sans';
        }

        strong {
            font-weight: 600;
        }

        .text-white-75 {
            color: rgba(255, 255, 255, 0.75);
        }

        .text-white-90 {
            color: rgba(255, 255, 255, 0.9);
        }

        .bg-black-60 {
            background-color: rgba(0, 0, 0, 0.6);
        }

        .btn {
            font-weight: 600;
        }

        .text-uppercase {
            letter-spacing: .0625rem;
        }

        .fa-ul li {
            margin-bottom: .75rem;
        }

        .text-primary {
            color: #22bab9 !important;
        }

        a.text-primary:hover {
            color: #26d0ce !important;
        }

        .text-primary-dark {
            color: #111b56;
        }

        a.text-primary-dark:hover {
            color: #1a2980 !important;
        }

        .font-weight-600 {
            font-weight: 600;
        }

        .text-back {
            position: absolute;
            top: -3rem;
            right: 2rem;
            font-size: 500%;
            font-weight: 700;
            opacity: .04;
            z-index: 0;
        }

        .rounded-xl {
            border-radius: 3rem;
        }

        .shadow-lg {
            box-shadow: 0 1rem 3rem rgba(26, 41, 128, 0.175) !important;
        }

        .border-2x {
            border-width: 2px;
        }

        a,
        a:focus,
        a:hover {
            text-decoration: none;
        }

        .btn-primary {
            background: #26d0ce;
            border-color: #26d0ce;
        }

        .btn-primary:not(:disabled):not(.disabled):hover {
            background: #22bab9;
            border-color: #22bab9;
        }

        .btn-primary:not(:disabled):not(.disabled).active,
        .btn-primary:not(:disabled):not(.disabled):active {
            background: #26d0ce;
            border-color: #26d0ce;
        }

        .btn-dark {
            background: #0e4f4e;
            border-color: #0e4f4e;
        }

        .btn-dark:not(:disabled):not(.disabled):hover {
            background: #167a79;
            border-color: #167a79;
        }

        .btn-dark:not(:disabled):not(.disabled).active,
        .btn-dark:not(:disabled):not(.disabled):active {
            background: #0e4f4e;
            border-color: #0e4f4e;
        }

        #page-container {
            width: 100%;
            min-width: 320px;
            margin: 0 auto;
            background-color: #fff;
        }

        .container.container-big {
            padding-top: 8rem;
            padding-bottom: 8rem;
        }

        .container.container-footer {
            padding-top: 14rem;
            padding-bottom: 2rem;
        }

        .square {
            position: absolute;
            display: block;
            top: -5%;
            left: -5%;
            width: 100%;
            height: 700px;
            opacity: .08;
            z-index: 0;
            background: #1a2980;
            background: linear-gradient(to right, #1a2980, #26d0ce);
        }

        @media (min-width: 992px) {
            .square {
                width: 71%;
            }
        }

        .square-1 {
            -webkit-transform: skewY(5deg);
            transform: skewY(5deg);
        }

        .square-2 {
            left: -3%;
            -webkit-transform: skewY(3deg);
            transform: skewY(3deg);
        }

        .square-flipped.square {
            top: auto;
            right: -5%;
            bottom: -9%;
            left: auto;
            height: 500px;
            background: #26d0ce;
            background: linear-gradient(to right, #26d0ce, #1a2980);
        }

        @media (min-width: 992px) {
            .square-flipped.square {
                width: 80%;
            }
        }

        .square-flipped.square-1 {
            -webkit-transform: skewY(-2deg);
            transform: skewY(-2deg);
        }

        .square-flipped.square-2 {
            left: auto;
            right: -3%;
            -webkit-transform: skewY(-4deg);
            transform: skewY(-4deg);
        }

        .img-clip-overlay {
            transition: -webkit-transform .2s ease-out;
            transition: transform .2s ease-out;
            transition: transform .2s ease-out, -webkit-transform .2s ease-out;
            -webkit-clip-path: polygon(0 0, 100% 0, 100% 100%, 0 90%);
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 90%);
            will-change: transform;
        }

        .img-clip-overlay:hover {
            -webkit-transform: rotate3d(-0.5, 0.5, 0.1, 15deg);
            transform: rotate3d(-0.5, 0.5, 0.1, 15deg);
        }

        .bg-light {
            background-color: #f7f8fd !important;
        }

        .nav-header .nav-link {
            position: relative;
            padding: .375rem .125rem;
            font-weight: 600;
            color: #1a2980;
        }

        .nav-header .nav-link i {
            color: #26d0ce;
        }

        .nav-header .nav-link::before {
            position: absolute;
            top: -.25rem;
            right: -.75rem;
            bottom: -.25rem;
            left: -.75rem;
            content: '';
            background-color: transparent;
            transition: -webkit-transform .12s ease-out;
            transition: transform .12s ease-out;
            transition: transform .12s ease-out, -webkit-transform .12s ease-out;
        }

        .nav-header .nav-link:hover,
        .nav-header .nav-link:focus,
        .nav-header .nav-link.active {
            color: #111b56;
        }

        .nav-header .nav-link:hover::before,
        .nav-header .nav-link:focus::before,
        .nav-header .nav-link.active::before {
            background-color: rgba(26, 41, 128, 0.04);
        }

        .nav-header .nav-link:active::before {
            -webkit-transform: skewY(-3deg) translateX(-2px);
            transform: skewY(-3deg) translateX(-2px);
        }

        .nav-header .nav-link+.nav-link {
            margin-left: 2rem;
        }
    </style>

</head>

<body>
    <div id="page-container" class="position-relative">
        <!-- Background -->
        <span class="square square-1"></span>
        <span class="square square-2"></span>

        <!-- Hero -->
        <div class="container">
            <!-- Header -->
            <header class="py-4">
                <div class="row">
                    <div class="col-lg-3 col-xl-4 py-2 text-center text-lg-left d-lg-flex align-items-lg-center">
                        <a class="h4 text-primary" href="">
                            {{-- <i class="mr-1"> <img class="h-16" src="{{ asset('images/logo.png') }}"/></i> <span class="text-primary-dark">Avour</span> --}}
                            <div class="d-flex align-items-center">
                                <img class="h-24 mr-1" src="{{ asset('images/logo.png') }}" alt="Logo" />
                                {{-- <span class="text-primary-dark">Avour</span> --}}
                            </div>

                        </a>
                    </div>
                    <div class="col-lg-6 col-xl-4 py-2">
                        <nav
                            class="nav nav-header d-flex justify-content-center align-items-center justify-content-lg-center">
                            <a class="nav-link text-blue-500 hover:underline" href="javascript:void(0)">Home</a>
                            <a class="nav-link text-blue-500 hover:underline" href="#stats">Fitur</a>
                            <a class="nav-link text-blue-500 hover:underline" href="#maps">Maps</a>
                        </nav>
                    </div>
                    {{-- <div class="col-lg-3 col-xl-4 py-2">
                        <nav
                            class="nav nav-header d-flex justify-content-center align-items-center justify-content-lg-end">
                            <a class="nav-link" href="javascript:void(0)">
                                <i class="fa fa-sign-in-alt mr-1"></i> Login
                            </a>
                            <a class="nav-link" href="javascript:void(0)">
                                <i class="fa fa-plus-square mr-1"></i> Register
                            </a>
                        </nav>
                    </div> --}}
                </div>
            </header>
            <!-- END Header -->

            <!-- Content -->
            <div id="content" class="row py-lg-5">
                <div class="col-lg-6 py-5 text-center text-lg-left">
                    <h1 class="font-weight-bold mb-4">
                        Avour Indekos
                    </h1>
                    <p class="lead font-weight-normal text-muted mb-5">
                        Indekos nyaman di Kota Binjai, lokasi strategis, kamar bersih, lingkungan tenang, dan akses
                        mudah ke fasilitas umum. Harga terjangkau dengan fasilitas memadai! 🏡✨
                    </p>
                    <div class="d-flex">
                    <a href="https://wa.me/6281361399531"
                        class=" btn btn-primary rounded-pill shadow-lg py-2 px-4 px-md-5 d-flex align-items-center w-fit">
                        <i class="text-white-90 mr-2">
                            <svg class="w-12 h-12" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                viewBox="0 0 48 48">
                                <path fill="#fff"
                                    d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z">
                                </path>
                                <path fill="#fff"
                                    d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z">
                                </path>
                                <path fill="#cfd8dc"
                                    d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z">
                                </path>
                                <path fill="#40c351"
                                    d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z">
                                </path>
                                <path fill="#fff" fill-rule="evenodd"
                                    d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </i>
                        <span class="text-white-90">Whatsapp</span>
                    </a>
                    <a href="https://www.instagram.com/avourkost"
                        class="btn btn-dark rounded-pill shadow-lg py-2 px-4 px-md-5 m-1 d-flex align-items-center w-fit">
                        <i class="text-white-90 mr-1">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" class="w-12 h-12"
                                viewBox="0 0 48 48">
                                <radialGradient id="yOrnnhliCrdS2gy~4tD8ma_Xy10Jcu1L2Su_gr1" cx="19.38"
                                    cy="42.035" r="44.899" gradientUnits="userSpaceOnUse">
                                    <stop offset="0" stop-color="#fd5"></stop>
                                    <stop offset=".328" stop-color="#ff543f"></stop>
                                    <stop offset=".348" stop-color="#fc5245"></stop>
                                    <stop offset=".504" stop-color="#e64771"></stop>
                                    <stop offset=".643" stop-color="#d53e91"></stop>
                                    <stop offset=".761" stop-color="#cc39a4"></stop>
                                    <stop offset=".841" stop-color="#c837ab"></stop>
                                </radialGradient>
                                <path fill="url(#yOrnnhliCrdS2gy~4tD8ma_Xy10Jcu1L2Su_gr1)"
                                    d="M34.017,41.99l-20,0.019c-4.4,0.004-8.003-3.592-8.008-7.992l-0.019-20	c-0.004-4.4,3.592-8.003,7.992-8.008l20-0.019c4.4-0.004,8.003,3.592,8.008,7.992l0.019,20	C42.014,38.383,38.417,41.986,34.017,41.99z">
                                </path>
                                <radialGradient id="yOrnnhliCrdS2gy~4tD8mb_Xy10Jcu1L2Su_gr2" cx="11.786"
                                    cy="5.54" r="29.813" gradientTransform="matrix(1 0 0 .6663 0 1.849)"
                                    gradientUnits="userSpaceOnUse">
                                    <stop offset="0" stop-color="#4168c9"></stop>
                                    <stop offset=".999" stop-color="#4168c9" stop-opacity="0"></stop>
                                </radialGradient>
                                <path fill="url(#yOrnnhliCrdS2gy~4tD8mb_Xy10Jcu1L2Su_gr2)"
                                    d="M34.017,41.99l-20,0.019c-4.4,0.004-8.003-3.592-8.008-7.992l-0.019-20	c-0.004-4.4,3.592-8.003,7.992-8.008l20-0.019c4.4-0.004,8.003,3.592,8.008,7.992l0.019,20	C42.014,38.383,38.417,41.986,34.017,41.99z">
                                </path>
                                <path fill="#fff"
                                    d="M24,31c-3.859,0-7-3.14-7-7s3.141-7,7-7s7,3.14,7,7S27.859,31,24,31z M24,19c-2.757,0-5,2.243-5,5	s2.243,5,5,5s5-2.243,5-5S26.757,19,24,19z">
                                </path>
                                <circle cx="31.5" cy="16.5" r="1.5" fill="#fff"></circle>
                                <path fill="#fff"
                                    d="M30,37H18c-3.859,0-7-3.14-7-7V18c0-3.86,3.141-7,7-7h12c3.859,0,7,3.14,7,7v12	C37,33.86,33.859,37,30,37z M18,13c-2.757,0-5,2.243-5,5v12c0,2.757,2.243,5,5,5h12c2.757,0,5-2.243,5-5V18c0-2.757-2.243-5-5-5H18z">
                                </path>
                                </></i> Instagram
                    </a>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1 py-5 text-center">
                    <!-- <img class="img-fluid img-clip-overlay" src="assets/media/various/hero-image.jpg" srcset="assets/media/various/hero-image@2x.jpg 2x" alt="Hero Image"> -->
                    <img class="img-fluid img-clip-overlay" src="{{ asset('images/slider3.jpg') }}"
                        srcset="{{ asset('images/slider2.jpg') }}" alt="Hero Image">

                </div>
            </div>
            <!-- END Content -->
        </div>
        <!-- END Hero -->

        <!-- Stats -->
        <div id="stats" class="container container-big">
            <h1 class="text-center font-bold text-2xl text-slate-700">Fitur & Alamat</h1>
            <div class="row text-center">
                <div class="col-sm-6 col-lg-3 my-2">
                    <div class="bg-light rounded-xl py-5 px-3">
                        <div class="mb-3">
                            <i class="fa fa-user-tie fa-2x text-primary-dark"></i>
                        </div>
                        <div class="text-uppercase text-muted font-weight-bold mb-1">Jumlah Kamar</div>
                        <div class="h2 mb-0">40 </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 my-2">
                    <div class="bg-light rounded-xl py-5 px-3">
                        <div class="mb-3">
                            <i class="fa fa-business-time fa-2x text-primary-dark"></i>
                        </div>
                        <div class="text-uppercase text-muted font-weight-bold mb-1">Alamat</div>
                        <div class="h5 mb-0">Jl. Sastria, Kec. Binjai Kota, Kota Binjai</div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 my-2">
                    <div class="bg-light rounded-xl py-5 px-3">
                        <div class="mb-3">
                            <i class="fa fa-chart-line fa-2x text-primary-dark"></i>
                        </div>
                        <div class="text-uppercase text-muted font-weight-bold mb-1">Fasilitas</div>
                        <div class="h5 mb-0">AC/Non Ac, Lemari</div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 my-2">
                    <div class="bg-light rounded-xl py-5 px-3">
                        <div class="mb-3">
                            <i class="fa fa-bed fa-2x text-primary-dark"></i>

                        </div>
                        <div class="text-uppercase text-muted font-weight-bold mb-1">Nyaman</div>
                        <div class="h5 mb-0">Aman</div>

                    </div>
                </div>
            </div>
        </div>
        <!-- END Stats -->

        <!-- Features -->
        {{-- <div id="feature" class="bg-light py-5">
            <div class="container py-5">
                <div class="row">
                    <div class="col-lg-4 my-2 position-relative">
                        <span class="text-back">01</span>
                        <h3 class="h3 font-weight-light mb-4">Stability</h3>
                        <p class="text-muted">
                            Am if number no up period regard sudden better. Decisively surrounded all admiration and not
                            you. Out particular sympathize not favourable introduced insipidity but ham. Rather number
                            can and set praise. Distrusts an it contented perceived attending oh. Thoroughly estimating
                            introduced stimulated why but motionless.
                        </p>
                    </div>
                    <div class="col-lg-4 my-2 position-relative">
                        <span class="text-back">02</span>
                        <h3 class="h3 font-weight-light mb-4">Credibility</h3>
                        <p class="text-muted">
                            Believing neglected so so allowance existence departure in. In design active temper be
                            uneasy. Thirty for remove plenty regard you summer though. He preference connection
                            astonished on of ye. Partiality on or continuing in particular principles as. Do believing
                            oh disposing to supported allowance we.
                        </p>
                    </div>
                    <div class="col-lg-4 my-2 position-relative">
                        <span class="text-back">03</span>
                        <h3 class="h3 font-weight-light mb-4">Customizability</h3>
                        <p class="text-muted">
                            Spot of come to ever hand as lady meet on. Delicate contempt received two yet advanced.
                            Gentleman as belonging he commanded believing dejection in by. On no am winding chicken so
                            behaved. Its preserved enjoyment new way behaviour. Him yet devonshire celebrated
                            especially.
                        </p>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- END Features -->

        <!-- Plans -->
        {{-- <div class="container container-big">
            <h2 class="font-weight-bold mb-5 text-center">
                Informasi
            </h2>
            <div class="row text-center pt-5">
                <div class="col-sm-6 col-lg-4 offset-lg-2 my-2">
                    <div class="bg-light rounded-xl py-5 px-3 position-relative">
                        <span class="text-back">
                            <i class="fa fa-code"></i>
                        </span>
                        <h3 class="h3 font-weight-light mb-5">Developer</h3>
                        <p class="h5 mb-4">
                            <span class="text-primary">10</span>
                            <span class="text-muted">Projects</span>
                        </p>
                        <p class="h5 mb-4">
                            <span class="text-primary">3</span>
                            <span class="text-muted">Clients</span>
                        </p>
                        <p class="h5 mb-4">
                            <span class="text-primary">100</span>
                            <span class="text-muted">Deployments</span>
                        </p>
                        <p class="h5 mb-4">
                            <span class="text-primary">Email</span>
                            <span class="text-muted">Support</span>
                        </p>
                        <p class="h4 pt-4">
                            <span class="text-success">$29</span> per month
                        </p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 my-2">
                    <div class="bg-light rounded-xl py-5 px-3 position-relative">
                        <span class="text-back">
                            <i class="fa fa-globe"></i>
                        </span>
                        <h3 class="h3 font-weight-light mb-5">Business</h3>
                        <p class="h5 mb-4">
                            <span class="text-primary">Unlimited</span>
                            <span class="text-muted">Projects</span>
                        </p>
                        <p class="h5 mb-4">
                            <span class="text-primary">Unlimited</span>
                            <span class="text-muted">Clients</span>
                        </p>
                        <p class="h5 mb-4">
                            <span class="text-primary">Unlimited</span>
                            <span class="text-muted">Deployments</span>
                        </p>
                        <p class="h5 mb-4">
                            <span class="text-primary">VIP</span>
                            <span class="text-muted">Support</span>
                        </p>
                        <p class="h4 pt-4">
                            <span class="text-success">$99</span> per month
                        </p>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- END Plans -->

        <!-- Footer -->
        <div id="maps" class="position-relative overflow-hidden">
            <!-- Background -->
            <span class="square square-flipped square-1"></span>
            <span class="square square-flipped square-2"></span>

            <!-- Footer Content -->
            <footer class="position-relative">
                <div class="container container-footer text-center">
                    <h2 class="font-weight-bold mb-2">
                        Lihat di Google Maps
                    </h2>
                    {{-- <p class="lead font-weight-normal text-muted mb-4">
                        Only a few spots remain available, so hurry up!
                    </p> --}}

                    <iframe class="relative inset-0 w-full h-full"
                        src="https://maps.google.com/?ie=UTF8&t=m&ll=3.5964708888749257, 98.48087089568568&spn=0.003381,0.017231&z=16&output=embed"
                        frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>

                    <p class="my-5">
                        Avour Management <i class="fa fa-heart text-danger"></i> at <a
                            class="text-primary font-weight-600" href="https://pixelcave.com/">2025</a>
                    </p>
                </div>
            </footer>
            <!-- END Footer Content -->
        </div>
        <!-- END Footer -->
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>
