{{-- resources/views/layouts/app.blade.php --}}
    <!DOCTYPE html>
<html lang="fr" data-theme="light" data-layout="horizontal">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="TogoGreenFund - Plateforme de financement participatif pour les projets écologiques et innovants au Togo">

    <title>@yield('title', 'Tableau de bord') — TogoGreenFund</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('app/assets/img/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('app/assets/img/apple-touch-icon.png') }}">

    <!-- Google Fonts - Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('app/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('app/assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/assets/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('app/assets/plugins/tabler-icons/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/assets/plugins/@simonwep/pickr/themes/nano.min.css') }}">

    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('app/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('app/assets/css/mystyle.css') }}">

    <!-- CSS personnalisé TogoGreenFund -->
    <style>
        :root {
            /* Couleurs principales - Chartre TogoGreenFund */
            --tgf-primary: #1B4D3E;
            --tgf-primary-dark: #0F3328;
            --tgf-primary-light: #2A7A62;
            --tgf-primary-lighter: #E8F5F0;

            --tgf-accent: #F5A623;
            --tgf-accent-light: #FFC857;
            --tgf-accent-dark: #D4891A;
            --tgf-accent-lighter: #FFF8E7;

            --tgf-secondary: #4A7C6F;
            --tgf-success: #2E8B57;
            --tgf-danger: #DC3545;
            --tgf-warning: #F5A623;
            --tgf-info: #2B7A9E;
            --tgf-muted: #6B8A7E;

            /* Neutres */
            --tgf-bg: #F0F5F2;
            --tgf-card-bg: #FFFFFF;
            --tgf-border: #DCE8E0;
            --tgf-text-primary: #1A2E2A;
            --tgf-text-secondary: #4A6A5E;
            --tgf-text-muted: #8AA89A;

            /* Ombres et rayon */
            --tgf-shadow: 0 2px 16px rgba(27, 77, 62, 0.08);
            --tgf-shadow-hover: 0 8px 32px rgba(27, 77, 62, 0.15);
            --tgf-shadow-lg: 0 12px 48px rgba(27, 77, 62, 0.12);

            --tgf-radius: 12px;
            --tgf-radius-lg: 16px;
            --tgf-radius-xl: 24px;

            /* Gradients */
            --tgf-gradient-primary: linear-gradient(135deg, var(--tgf-primary-dark) 0%, var(--tgf-primary) 50%, var(--tgf-primary-light) 100%);
            --tgf-gradient-accent: linear-gradient(135deg, var(--tgf-accent) 0%, var(--tgf-accent-light) 100%);
            --tgf-gradient-success: linear-gradient(135deg, #2E8B57 0%, #3CB371 100%);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Manrope', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--tgf-bg);
            color: var(--tgf-text-primary);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            line-height: 1.6;
        }

        /* ============================================
           SCROLLBAR
        ============================================ */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--tgf-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--tgf-primary-light);
            border-radius: 8px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--tgf-primary);
        }

        /* ============================================
           SELECTION
        ============================================ */
        ::selection {
            background: var(--tgf-primary);
            color: #fff;
        }

        /* ============================================
           PAGE WRAPPER
        ============================================ */
        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-top: 70px;
        }

        /* ============================================
           PAGE HEADER BAR
        ============================================ */
        .page-header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            padding: 20px 30px;
            background: var(--tgf-card-bg);
            border-bottom: 2px solid var(--tgf-border);
            margin-bottom: 24px;
            border-radius: 0 0 var(--tgf-radius-lg) var(--tgf-radius-lg);
            box-shadow: var(--tgf-shadow);
        }

        .page-header-left {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-title-main {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Manrope', sans-serif;
            font-weight: 700;
            font-size: 1.35rem;
            color: var(--tgf-primary);
            margin: 0;
            letter-spacing: -0.3px;
        }

        .title-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: var(--tgf-primary-lighter);
            border-radius: 12px;
            color: var(--tgf-accent);
            font-size: 1.15rem;
            border: 1px solid rgba(245, 166, 35, 0.2);
        }

        .breadcrumb-custom {
            display: flex;
            align-items: center;
            gap: 8px;
            list-style: none;
            padding: 0;
            margin: 0;
            font-family: 'Manrope', sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--tgf-text-muted);
            flex-wrap: wrap;
        }

        .breadcrumb-custom li {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .breadcrumb-custom li:not(:last-child)::after {
            content: '›';
            color: var(--tgf-text-muted);
            font-size: 1.1rem;
            opacity: 0.6;
        }

        .breadcrumb-custom a {
            color: var(--tgf-secondary);
            text-decoration: none;
            transition: color 0.2s;
        }

        .breadcrumb-custom a:hover {
            color: var(--tgf-accent);
        }

        .breadcrumb-custom .active {
            color: var(--tgf-primary);
            font-weight: 600;
        }

        .page-header-right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* ============================================
           CONTENT AREA
        ============================================ */
        .content-area {
            flex: 1;
            padding: 0 30px 30px;
        }

        /* ============================================
           BADGES ET TAGS
        ============================================ */
        .badge-tgf {
            font-family: 'Manrope', sans-serif;
            font-weight: 600;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            letter-spacing: 0.3px;
        }

        .badge-tgf-primary {
            background: var(--tgf-primary-lighter);
            color: var(--tgf-primary);
        }

        .badge-tgf-accent {
            background: var(--tgf-accent-lighter);
            color: var(--tgf-accent-dark);
        }

        .badge-tgf-success {
            background: #E8F5ED;
            color: var(--tgf-success);
        }

        .badge-tgf-danger {
            background: #FDE8E8;
            color: var(--tgf-danger);
        }

        .badge-tgf-warning {
            background: #FFF8E7;
            color: var(--tgf-warning);
        }

        /* ============================================
           BUTTONS
        ============================================ */
        .btn-tgf-primary {
            background: var(--tgf-primary);
            color: #fff;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: var(--tgf-radius);
            font-family: 'Manrope', sans-serif;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-tgf-primary:hover {
            background: var(--tgf-primary-dark);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: var(--tgf-shadow-hover);
        }

        .btn-tgf-accent {
            background: var(--tgf-accent);
            color: #fff;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: var(--tgf-radius);
            font-family: 'Manrope', sans-serif;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-tgf-accent:hover {
            background: var(--tgf-accent-dark);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: var(--tgf-shadow-hover);
        }

        .btn-tgf-outline-primary {
            background: transparent;
            color: var(--tgf-primary);
            border: 2px solid var(--tgf-primary);
            padding: 0.6rem 1.5rem;
            border-radius: var(--tgf-radius);
            font-family: 'Manrope', sans-serif;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-tgf-outline-primary:hover {
            background: var(--tgf-primary);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: var(--tgf-shadow-hover);
        }

        /* ============================================
           CARDS
        ============================================ */
        .card-tgf {
            background: var(--tgf-card-bg);
            border: none;
            border-radius: var(--tgf-radius-lg);
            box-shadow: var(--tgf-shadow);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card-tgf:hover {
            box-shadow: var(--tgf-shadow-hover);
        }

        .card-tgf .card-header {
            background: transparent;
            border-bottom: 1px solid var(--tgf-border);
            padding: 18px 24px;
            font-weight: 600;
            font-family: 'Manrope', sans-serif;
            color: var(--tgf-primary);
            font-size: 1rem;
        }

        .card-tgf .card-header .card-title-icon {
            color: var(--tgf-accent);
            margin-right: 8px;
        }

        .card-tgf .card-body {
            padding: 24px;
        }

        .card-tgf .card-footer {
            background: transparent;
            border-top: 1px solid var(--tgf-border);
            padding: 16px 24px;
        }

        /* ============================================
           STAT CARDS
        ============================================ */
        .stat-card-tgf {
            background: var(--tgf-card-bg);
            border-radius: var(--tgf-radius-lg);
            padding: 1.5rem;
            box-shadow: var(--tgf-shadow);
            transition: all 0.3s ease;
            border-left: 4px solid var(--tgf-primary);
        }

        .stat-card-tgf:hover {
            transform: translateY(-4px);
            box-shadow: var(--tgf-shadow-hover);
        }

        .stat-card-tgf .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .stat-card-tgf .stat-number {
            font-family: 'Manrope', sans-serif;
            font-weight: 800;
            font-size: 1.8rem;
            color: var(--tgf-primary);
            line-height: 1.2;
        }

        .stat-card-tgf .stat-label {
            font-family: 'Manrope', sans-serif;
            font-size: 0.85rem;
            color: var(--tgf-text-muted);
            font-weight: 500;
        }

        .stat-card-tgf .stat-trend {
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* ============================================
           FORM ELEMENTS
        ============================================ */
        .form-control-tgf {
            border: 2px solid var(--tgf-border);
            border-radius: var(--tgf-radius);
            padding: 0.7rem 1rem;
            font-family: 'Manrope', sans-serif;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #fff;
            color: var(--tgf-text-primary);
        }

        .form-control-tgf:focus {
            border-color: var(--tgf-primary);
            box-shadow: 0 0 0 4px rgba(27, 77, 62, 0.08);
            outline: none;
        }

        .form-control-tgf.is-invalid {
            border-color: var(--tgf-danger);
        }

        .form-label-tgf {
            font-family: 'Manrope', sans-serif;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--tgf-text-secondary);
            margin-bottom: 6px;
        }

        /* ============================================
           TABLES
        ============================================ */
        .table-tgf {
            font-family: 'Manrope', sans-serif;
        }

        .table-tgf thead th {
            background: var(--tgf-primary-lighter);
            color: var(--tgf-primary);
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--tgf-border);
            padding: 12px 16px;
        }

        .table-tgf tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            border-bottom: 1px solid var(--tgf-border);
            color: var(--tgf-text-secondary);
        }

        .table-tgf tbody tr:hover {
            background: var(--tgf-primary-lighter);
        }

        /* ============================================
           HEADER CUSTOM
        ============================================ */
        .navbar-tgf {
            background: var(--tgf-gradient-primary);
            padding: 0.5rem 0;
            box-shadow: 0 2px 20px rgba(27, 77, 62, 0.2);
        }

        .navbar-tgf .navbar-brand {
            font-family: 'Manrope', sans-serif;
            font-weight: 800;
            font-size: 1.3rem;
            color: #fff;
        }

        .navbar-tgf .navbar-brand i {
            color: var(--tgf-accent);
        }

        .navbar-tgf .nav-link {
            color: rgba(255,255,255,0.8);
            font-family: 'Manrope', sans-serif;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .navbar-tgf .nav-link:hover {
            color: #fff;
        }

        .navbar-tgf .nav-link.active {
            color: var(--tgf-accent);
        }

        .navbar-tgf .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--tgf-accent);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 0.85rem;
            font-family: 'Manrope', sans-serif;
        }

        /* ============================================
           FOOTER
        ============================================ */
        .footer-tgf {
            background: var(--tgf-card-bg);
            border-top: 1px solid var(--tgf-border);
            padding: 1.5rem 0;
            margin-top: 2rem;
            font-family: 'Manrope', sans-serif;
            font-size: 0.85rem;
            color: var(--tgf-text-muted);
        }

        .footer-tgf a {
            color: var(--tgf-primary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-tgf a:hover {
            color: var(--tgf-accent);
        }

        /* ============================================
           TOAST CONTAINER
        ============================================ */
        #toast-container {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 9999;
            max-width: 380px;
            width: 100%;
        }

        /* ============================================
           UTILITIES TGF
        ============================================ */
        .text-tgf-primary { color: var(--tgf-primary); }
        .text-tgf-accent { color: var(--tgf-accent); }
        .text-tgf-success { color: var(--tgf-success); }
        .text-tgf-danger { color: var(--tgf-danger); }
        .text-tgf-warning { color: var(--tgf-warning); }
        .text-tgf-info { color: var(--tgf-info); }
        .text-tgf-muted { color: var(--tgf-text-muted); }

        .bg-tgf-primary { background: var(--tgf-primary); }
        .bg-tgf-primary-light { background: var(--tgf-primary-lighter); }
        .bg-tgf-accent { background: var(--tgf-accent); }
        .bg-tgf-accent-light { background: var(--tgf-accent-lighter); }
        .bg-tgf-success { background: var(--tgf-success); }
        .bg-tgf-danger { background: var(--tgf-danger); }
        .bg-tgf-warning { background: var(--tgf-warning); }
        .bg-tgf-info { background: var(--tgf-info); }

        .fw-200 { font-weight: 200; }
        .fw-300 { font-weight: 300; }
        .fw-400 { font-weight: 400; }
        .fw-500 { font-weight: 500; }
        .fw-600 { font-weight: 600; }
        .fw-700 { font-weight: 700; }
        .fw-800 { font-weight: 800; }

        .rounded-tgf { border-radius: var(--tgf-radius); }
        .rounded-tgf-lg { border-radius: var(--tgf-radius-lg); }
        .rounded-tgf-xl { border-radius: var(--tgf-radius-xl); }

        .shadow-tgf { box-shadow: var(--tgf-shadow); }
        .shadow-tgf-hover:hover { box-shadow: var(--tgf-shadow-hover); }
        .shadow-tgf-lg { box-shadow: var(--tgf-shadow-lg); }

        .transition-tgf { transition: all 0.3s ease; }

        .border-tgf { border: 1px solid var(--tgf-border); }
        .border-tgf-primary { border: 1px solid var(--tgf-primary); }
        .border-tgf-accent { border: 1px solid var(--tgf-accent); }

        /* ============================================
           RESPONSIVE
        ============================================ */
        @media (max-width: 991.98px) {
            .page-header-bar {
                padding: 16px 20px;
                flex-direction: column;
                align-items: stretch;
            }

            .page-header-left {
                flex-direction: column;
                align-items: stretch;
            }

            .page-title-main {
                font-size: 1.1rem;
            }

            .content-area {
                padding: 0 16px 16px;
            }

            .stat-card-tgf .stat-number {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 576px) {
            .page-header-bar {
                padding: 12px 16px;
            }

            .page-title-main {
                font-size: 1rem;
            }

            .title-icon {
                width: 32px;
                height: 32px;
                font-size: 0.9rem;
            }

            .breadcrumb-custom {
                font-size: 0.75rem;
            }

            .card-tgf .card-header {
                padding: 14px 16px;
                font-size: 0.9rem;
            }

            .card-tgf .card-body {
                padding: 16px;
            }

            .stat-card-tgf {
                padding: 1rem;
            }

            .stat-card-tgf .stat-number {
                font-size: 1.2rem;
            }
        }

        /* ============================================
           ANIMATIONS
        ============================================ */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        .pulse-dot {
            animation: pulse-dot 2s ease-in-out infinite;
        }
    </style>

    {{-- CSS supplémentaire --}}
    @stack('css')
    @yield('css')
</head>

<body class="menu-horizontal">

{{-- Toast notifications --}}
<div id="toast-container" aria-live="polite" aria-atomic="true"></div>

{{-- Modale de recherche --}}
@include('layouts.partials._search')

{{-- En-tête TogoGreenFund --}}
@include('layouts.partials._header')

{{-- Wrapper principal --}}
<div class="page-wrapper">

    {{-- Barre de contexte --}}
    @hasSection('page_title')
        <div class="page-header-bar">
            <div class="page-header-left">
                <h1 class="page-title-main">
                    <span class="title-icon">
                        <i class="fas @yield('page_icon', 'fa-leaf')"></i>
                    </span>
                    @yield('page_title')
                </h1>
                @hasSection('breadcrumb')
                    <nav aria-label="Fil d'Ariane">
                        <ul class="breadcrumb-custom">
                            @yield('breadcrumb')
                        </ul>
                    </nav>
                @endif
            </div>
            <div class="page-header-right">
                @yield('page_actions')
            </div>
        </div>
    @endif

    {{-- Contenu principal --}}
    <main class="content-area" role="main">
        @yield('contenu')
    </main>

    {{-- Pied de page --}}
    @include('layouts.partials._footer')

</div>

{{-- Scripts requis --}}
<script src="{{ asset('app/assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="{{ asset('app/assets/js/feather.min.js') }}"></script>
<script src="{{ asset('app/assets/js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('app/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('app/assets/js/moment.min.js') }}"></script>
<script src="{{ asset('app/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('app/assets/plugins/chartjs/chart.min.js') }}"></script>
<script src="{{ asset('app/assets/plugins/chartjs/chart-data.js') }}"></script>
<script src="{{ asset('app/assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('app/assets/plugins/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ asset('app/assets/plugins/apexchart/chart-data.js') }}"></script>
<script src="{{ asset('app/assets/plugins/@simonwep/pickr/pickr.es5.min.js') }}"></script>
<script src="{{ asset('app/assets/js/theme-colorpicker.js') }}"></script>
<script src="{{ asset('app/assets/js/script.js') }}"></script>

{{-- Toastr pour les notifications --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script>
    // Configuration de Toastr
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000",
        "extendedTimeOut": "2000",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "preventDuplicates": true,
        "newestOnTop": true
    };

    // Configuration de Select2 en français
    $(document).ready(function() {
        if ($.fn.select2) {
            $.fn.select2.defaults.set('language', {
                inputTooShort: function(args) {
                    return 'Veuillez saisir ' + (args.min - args.input.length) + ' caractère(s) supplémentaire(s)';
                },
                noResults: function() {
                    return 'Aucun résultat trouvé';
                },
                searching: function() {
                    return 'Recherche en cours...';
                }
            });
        }
    });

    // Initialisation de Feather Icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }

    // Gestion des messages flash
    @if(session('success'))
    toastr.success('{{ session('success') }}', '✅ Succès');
    @endif

    @if(session('error'))
    toastr.error('{{ session('error') }}', '❌ Erreur');
    @endif

    @if(session('warning'))
    toastr.warning('{{ session('warning') }}', '⚠️ Attention');
    @endif

    @if(session('info'))
    toastr.info('{{ session('info') }}', 'ℹ️ Information');
    @endif
</script>

{{-- JS supplémentaire --}}
@stack('js')
@yield('js')

</body>
</html>
