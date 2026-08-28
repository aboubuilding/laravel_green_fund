{{-- resources/views/auth/login.blade.php --}}
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion · TogoGreenFund</title>

    <!-- Source Sans 3 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- SweetAlert2 & Toastr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <style>
        :root {
            --tgf-primary: #1B4D3E;
            --tgf-primary-dark: #0F3328;
            --tgf-primary-light: #2A7A62;
            --tgf-accent: #F5A623;
            --tgf-accent-light: #FFC857;
            --tgf-accent-dark: #D4891A;
            --tgf-success: #2E8B57;
            --tgf-danger: #DC3545;
            --tgf-bg: #F0F4F2;
            --tgf-card-bg: #FFFFFF;
            --tgf-shadow: 0 20px 60px rgba(27, 77, 62, 0.15);
            --tgf-border-radius: 20px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Source Sans 3', sans-serif;
            min-height: 100vh;
            background: var(--tgf-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
        }

        /* Loader */
        #global-loader {
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }
        #global-loader.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        .tgf-loader-ring {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            border: 4px solid #eef0f3;
            border-top-color: var(--tgf-accent);
            animation: tgfSpin 0.8s linear infinite;
        }
        @keyframes tgfSpin { to { transform: rotate(360deg); } }

        .tgf-wrapper {
            width: 100%;
            max-width: 1100px;
            background: var(--tgf-card-bg);
            border-radius: var(--tgf-border-radius);
            box-shadow: var(--tgf-shadow);
            display: flex;
            overflow: hidden;
            position: relative;
            animation: fadeInUp 0.6s ease-out;
        }

        .tgf-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--tgf-primary), var(--tgf-accent), var(--tgf-primary));
            z-index: 2;
        }

        /* ============== PANEL GAUCHE ============== */
        .tgf-brand-panel {
            flex: 0 0 45%;
            background: linear-gradient(135deg, var(--tgf-primary-dark), var(--tgf-primary), var(--tgf-primary-light));
            padding: 50px 40px;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .tgf-brand-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 80%, rgba(245, 166, 35, 0.1), transparent 60%),
                repeating-linear-gradient(45deg, transparent, transparent 30px, rgba(255,255,255,0.02) 30px, rgba(255,255,255,0.02) 31px);
            pointer-events: none;
        }

        .tgf-brand-content {
            position: relative;
            z-index: 1;
        }

        .tgf-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .tgf-logo-icon {
            width: 60px;
            height: 60px;
            background: rgba(245, 166, 35, 0.15);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--tgf-accent);
            border: 2px solid rgba(245, 166, 35, 0.3);
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .tgf-logo:hover .tgf-logo-icon {
            transform: scale(1.05) rotate(-3deg);
        }

        .tgf-logo-text {
            font-weight: 800;
            font-size: 1.6rem;
            line-height: 1.2;
            font-family: 'Source Sans 3', sans-serif;
        }

        .tgf-logo-text small {
            display: block;
            font-weight: 500;
            font-size: 0.6rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.5);
            margin-top: 4px;
        }

        .tgf-brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2.5px;
            color: var(--tgf-accent-light);
            margin-bottom: 14px;
        }

        .tgf-brand-badge::before {
            content: '';
            width: 28px;
            height: 2px;
            background: var(--tgf-accent);
        }

        .tgf-brand-title {
            font-weight: 800;
            font-size: 2.2rem;
            line-height: 1.15;
            margin-bottom: 15px;
            font-family: 'Source Sans 3', sans-serif;
        }

        .tgf-brand-title span {
            color: var(--tgf-accent);
            position: relative;
        }

        .tgf-brand-title span::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--tgf-accent);
            border-radius: 2px;
            opacity: 0.4;
        }

        .tgf-brand-desc {
            color: rgba(255,255,255,0.75);
            line-height: 1.8;
            font-size: 0.95rem;
            margin-bottom: 30px;
        }

        .tgf-features {
            list-style: none;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .tgf-features li {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,0.85);
            font-weight: 500;
            font-size: 0.9rem;
            opacity: 0;
            transform: translateX(-8px);
            animation: tgfFeatureIn 0.5s ease-out forwards;
        }

        .tgf-features li:nth-child(1) { animation-delay: 0.1s; }
        .tgf-features li:nth-child(2) { animation-delay: 0.2s; }
        .tgf-features li:nth-child(3) { animation-delay: 0.3s; }
        .tgf-features li:nth-child(4) { animation-delay: 0.4s; }

        @keyframes tgfFeatureIn {
            to { opacity: 1; transform: translateX(0); }
        }

        .tgf-features li i {
            width: 32px;
            height: 32px;
            background: rgba(245, 166, 35, 0.12);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--tgf-accent);
            font-size: 0.9rem;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .tgf-features li:hover i {
            background: rgba(245, 166, 35, 0.22);
            transform: scale(1.05);
        }

        .tgf-brand-footer {
            margin-top: auto;
            padding-top: 22px;
            font-size: 0.68rem;
            color: rgba(255,255,255,0.32);
            letter-spacing: 0.3px;
            border-top: 1px solid rgba(255,255,255,0.07);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ============== PANEL DROIT ============== */
        .tgf-form-panel {
            flex: 1;
            padding: 50px 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #fff;
        }

        .tgf-form-inner {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .tgf-mobile-logo {
            display: none;
            text-align: center;
            margin-bottom: 24px;
        }

        .tgf-mobile-logo .logo-icon {
            width: 48px;
            height: 48px;
            background: var(--tgf-primary);
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: var(--tgf-accent);
            margin-bottom: 8px;
        }

        .tgf-mobile-logo h5 {
            font-weight: 700;
            color: var(--tgf-primary);
            margin: 0;
            font-size: 1rem;
            font-family: 'Source Sans 3', sans-serif;
        }

        .tgf-form-header {
            margin-bottom: 30px;
        }

        .tgf-form-header .tgf-icon-badge {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--tgf-primary), var(--tgf-primary-light));
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--tgf-accent);
            margin-bottom: 15px;
            box-shadow: 0 10px 24px rgba(27, 77, 62, 0.2);
            transition: transform 0.3s ease;
        }

        .tgf-form-header .tgf-icon-badge:hover {
            transform: scale(1.05);
        }

        .tgf-form-header h3 {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--tgf-primary);
            margin-bottom: 5px;
            font-family: 'Source Sans 3', sans-serif;
        }

        .tgf-form-header p {
            color: #6B7A8F;
            font-size: 0.9rem;
            margin: 0;
        }

        /* Alert Banner */
        .tgf-alert-banner {
            display: none;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.85rem;
            border: 1px solid transparent;
            align-items: flex-start;
            gap: 10px;
            animation: alertIn 0.25s ease-out both;
        }

        .tgf-alert-banner.show {
            display: flex;
        }

        .tgf-alert-banner.danger {
            background: #FEF2F2;
            border-color: #FECACA;
            color: var(--tgf-danger);
        }

        .tgf-alert-banner.warning {
            background: #FFFBEB;
            border-color: #FDE68A;
            color: #92400E;
        }

        .tgf-alert-banner.success {
            background: #F0FDF4;
            border-color: #BBF7D0;
            color: var(--tgf-success);
        }

        @keyframes alertIn {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Form */
        .tgf-label {
            font-weight: 600;
            font-size: 0.8rem;
            color: #1A202C;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: 'Source Sans 3', sans-serif;
        }

        .tgf-label i {
            color: var(--tgf-primary);
        }

        .tgf-label .required {
            color: var(--tgf-danger);
        }

        .tgf-input-group {
            display: flex;
            align-items: stretch;
            background: #F8FAFA;
            border: 2px solid #E2E8F0;
            border-radius: 12px;
            transition: all 0.25s ease;
            overflow: hidden;
        }

        .tgf-input-group:focus-within {
            border-color: var(--tgf-primary);
            box-shadow: 0 0 0 4px rgba(27, 77, 62, 0.08);
            background: #fff;
        }

        .tgf-input-group:focus-within .input-group-text:first-child {
            color: var(--tgf-accent);
        }

        .tgf-input-group.is-invalid {
            border-color: var(--tgf-danger);
            background: #FEF2F2;
        }

        .tgf-input-group.is-invalid:focus-within {
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.08);
        }

        .tgf-input-group .form-control {
            border: none;
            background: transparent;
            padding: 13px 16px;
            font-size: 0.9rem;
            box-shadow: none !important;
            color: #1A202C;
            font-weight: 500;
            font-family: 'Source Sans 3', sans-serif;
        }

        .tgf-input-group .form-control:focus {
            outline: none;
            box-shadow: none;
        }

        .tgf-input-group .form-control::placeholder {
            color: #A0AEC0;
            font-weight: 400;
        }

        .tgf-input-group .input-group-text {
            border: none;
            background: transparent;
            color: #A0AEC0;
            padding: 0 14px;
            font-size: 1rem;
            transition: color 0.2s;
        }

        .tgf-input-group .toggle-password {
            cursor: pointer;
            transition: color 0.2s;
        }

        .tgf-input-group .toggle-password:hover {
            color: var(--tgf-primary);
        }

        .invalid-feedback.d-block {
            display: flex !important;
            align-items: center;
            gap: 6px;
            font-size: 0.75rem;
            margin-top: 6px;
            color: var(--tgf-danger);
            font-weight: 500;
        }

        .tgf-row-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 16px 0 24px;
            font-size: 0.85rem;
        }

        /* Toggle Switch */
        .tgf-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            user-select: none;
        }

        .tgf-toggle input { display: none; }

        .tgf-toggle .switch {
            width: 36px;
            height: 20px;
            border-radius: 20px;
            background: #DCE1E8;
            position: relative;
            transition: background 0.2s ease;
            flex-shrink: 0;
        }

        .tgf-toggle .switch::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.25);
            transition: transform 0.2s ease;
        }

        .tgf-toggle input:checked + .switch {
            background: var(--tgf-accent);
        }

        .tgf-toggle input:checked + .switch::after {
            transform: translateX(16px);
        }

        .tgf-toggle .label-text {
            color: #4A5568;
            font-weight: 500;
            font-family: 'Source Sans 3', sans-serif;
        }

        .tgf-row-between a {
            color: var(--tgf-primary);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
            font-family: 'Source Sans 3', sans-serif;
        }

        .tgf-row-between a:hover {
            color: var(--tgf-accent-dark);
            text-decoration: underline;
        }

        /* Bouton */
        .tgf-btn-submit {
            width: 100%;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            font-size: 0.95rem;
            color: #fff;
            background: linear-gradient(120deg, var(--tgf-primary), var(--tgf-primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(27, 77, 62, 0.25);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            font-family: 'Source Sans 3', sans-serif;
        }

        .tgf-btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, var(--tgf-accent), var(--tgf-accent-dark));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .tgf-btn-submit:hover:not(:disabled)::before {
            opacity: 1;
        }

        .tgf-btn-submit:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(27, 77, 62, 0.35);
        }

        .tgf-btn-submit:active:not(:disabled) {
            transform: scale(0.97);
        }

        .tgf-btn-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .tgf-btn-submit span {
            position: relative;
            z-index: 1;
        }

        .tgf-btn-submit .btn-spinner {
            display: none;
            position: relative;
            z-index: 1;
        }

        .tgf-btn-submit.loading .btn-spinner {
            display: inline-block;
        }

        .tgf-btn-submit.loading .btn-text {
            display: none;
        }

        .tgf-secure-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 14px;
            font-size: 0.72rem;
            color: #A0AEC0;
            font-weight: 500;
        }

        .tgf-secure-note i {
            color: #B7C0CC;
        }

        .tgf-divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 20px 0 18px;
            color: #A0AEC0;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .tgf-divider span {
            flex: 1;
            height: 1px;
            background: #E2E8F0;
        }

        .tgf-register {
            text-align: center;
            font-size: 0.88rem;
            color: #4A5568;
            font-family: 'Source Sans 3', sans-serif;
        }

        .tgf-register a {
            color: var(--tgf-primary);
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s;
        }

        .tgf-register a:hover {
            color: var(--tgf-accent-dark);
            text-decoration: underline;
        }

        .tgf-footer-note {
            text-align: center;
            margin-top: 20px;
            font-size: 0.7rem;
            color: #A0AEC0;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .shake {
            animation: shake 0.4s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-6px); }
            20%, 40%, 60%, 80% { transform: translateX(6px); }
        }

        /* Toastr personnalisé */
        #toast-container > .toast-success { background-color: var(--tgf-success) !important; }
        #toast-container > .toast-error { background-color: var(--tgf-danger) !important; }
        #toast-container > .toast-warning { background-color: var(--tgf-accent) !important; }
        #toast-container > .toast-info { background-color: var(--tgf-primary) !important; }

        /* ============== RESPONSIVE ============== */
        @media (max-width: 991.98px) {
            .tgf-wrapper {
                flex-direction: column;
                max-width: 500px;
            }

            .tgf-brand-panel {
                flex: none;
                padding: 30px 25px;
                min-height: 260px;
            }

            .tgf-brand-panel .tgf-features {
                display: none;
            }

            .tgf-brand-title {
                font-size: 1.6rem;
            }

            .tgf-mobile-logo {
                display: block;
            }

            .tgf-form-panel {
                padding: 30px 25px;
            }

            .tgf-form-inner {
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 12px;
            }

            .tgf-brand-panel {
                padding: 20px 16px;
                min-height: 200px;
            }

            .tgf-brand-panel .tgf-brand-title {
                font-size: 1.3rem;
            }

            .tgf-brand-panel .tgf-brand-desc {
                font-size: 0.8rem;
            }

            .tgf-form-panel {
                padding: 20px 16px;
            }

            .tgf-form-header h3 {
                font-size: 1.2rem;
            }

            .tgf-logo-icon {
                width: 44px;
                height: 44px;
                font-size: 1.4rem;
            }

            .tgf-logo-text {
                font-size: 1.1rem;
            }

            .tgf-brand-badge {
                font-size: 0.55rem;
            }

            .tgf-row-between {
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .tgf-wrapper,
            .shake,
            .tgf-alert-banner,
            .tgf-features li {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }
    </style>
</head>
<body>

<!-- LOADER -->
<div id="global-loader">
    <div class="tgf-loader-ring" role="status" aria-label="Chargement"></div>
</div>

<!-- WRAPPER -->
<div class="tgf-wrapper">

    <!-- PANEL GAUCHE -->
    <aside class="tgf-brand-panel">
        <div class="tgf-brand-content">
            <div class="tgf-logo">
                <div class="tgf-logo-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <div class="tgf-logo-text">
                    TogoGreenFund
                    <small>Financement vert pour le Togo</small>
                </div>
            </div>

            <span class="tgf-brand-badge">Plateforme d'investissement vert</span>

            <h1 class="tgf-brand-title">
                Investissez dans un <span>avenir durable</span>
            </h1>

            <p class="tgf-brand-desc">
                Plateforme de financement participatif dédiée aux projets
                écologiques et innovants au Togo.
            </p>

            <ul class="tgf-features">
                <li><i class="fas fa-seedling"></i> Projets verts et durables</li>
                <li><i class="fas fa-hand-holding-usd"></i> Investissement responsable</li>
                <li><i class="fas fa-chart-line"></i> Suivi transparent des fonds</li>
                <li><i class="fas fa-globe-africa"></i> Impact local au Togo</li>
            </ul>

            <div class="tgf-brand-footer">
                <i class="fas fa-shield-halved"></i> &copy; {{ date('Y') }} TogoGreenFund — Tous droits réservés.
            </div>
        </div>
    </aside>

    <!-- PANEL DROIT -->
    <div class="tgf-form-panel">
        <div class="tgf-form-inner">

            <!-- Logo Mobile -->
            <div class="tgf-mobile-logo">
                <div class="logo-icon"><i class="fas fa-leaf"></i></div>
                <h5>TogoGreenFund</h5>
            </div>

            <!-- En-tête -->
            <div class="tgf-form-header">
                <div class="tgf-icon-badge">
                    <i class="fas fa-lock"></i>
                </div>
                <h3>Connexion</h3>
                <p>Accédez à votre espace investisseur</p>
            </div>

            <!-- Alert Banner -->
            <div id="alert-banner" class="tgf-alert-banner" role="alert" aria-live="assertive">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong id="alert-title"></strong>
                    <span id="alert-text"></span>
                </div>
            </div>

            <!-- Formulaire -->
            <form id="login-form" autocomplete="off" novalidate>
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label class="tgf-label" for="email">
                        <i class="fas fa-envelope"></i> Adresse email
                        <span class="required">*</span>
                    </label>
                    <div class="tgf-input-group" id="group-email">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" id="email" class="form-control"
                               placeholder="exemple@domaine.com"
                               autocomplete="email"
                               required
                               autofocus
                               aria-describedby="error-email">
                    </div>
                    <div class="invalid-feedback d-block" id="error-email" style="display:none;">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>L'email est obligatoire</span>
                    </div>
                </div>

                <!-- Mot de passe -->
                <div class="mb-2">
                    <label class="tgf-label" for="mot_de_passe">
                        <i class="fas fa-key"></i> Mot de passe
                        <span class="required">*</span>
                    </label>
                    <div class="tgf-input-group" id="group-password">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="mot_de_passe" id="mot_de_passe"
                               class="form-control"
                               placeholder="••••••••"
                               autocomplete="current-password"
                               required
                               aria-describedby="error-password">
                        <span class="input-group-text toggle-password" id="togglePassword"
                              role="button" tabindex="0"
                              aria-label="Afficher le mot de passe">
                                <i class="fas fa-eye-slash" id="eye-icon"></i>
                            </span>
                    </div>
                    <div class="invalid-feedback d-block" id="error-password" style="display:none;">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Le mot de passe est obligatoire</span>
                    </div>
                </div>

                <!-- Options -->
                <div class="tgf-row-between">
                    <label class="tgf-toggle" for="remember">
                        <input type="checkbox" name="remember" id="remember">
                        <span class="switch"></span>
                        <span class="label-text">Se souvenir de moi</span>
                    </label>
                    <a href="#" id="forgot-link">Mot de passe oublié ?</a>
                </div>

                <!-- Bouton -->
                <button type="submit" class="tgf-btn-submit" id="btn-login">
                        <span class="btn-spinner">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </span>
                    <span class="btn-text"><i class="fas fa-sign-in-alt"></i> Se connecter</span>
                </button>

                <p class="tgf-secure-note">
                    <i class="fas fa-shield-alt"></i> Connexion sécurisée
                </p>

                <!-- Divider -->
                <div class="tgf-divider">
                    <span></span> ou <span></span>
                </div>

                <!-- Lien inscription -->
                <p class="tgf-register">
                    Nouveau sur TogoGreenFund ?
                    <a href="#"><i class="fas fa-user-plus"></i> Créer un compte</a>
                </p>

            </form>

            <!-- Footer -->
            <div class="tgf-footer-note">
                &copy; {{ date('Y') }} <strong>TogoGreenFund</strong> — Tous droits réservés.
            </div>

        </div>
    </div>
</div>

<!-- ============== SCRIPTS ============== -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    // ============================================
    // CONFIGURATION
    // ============================================

    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000,
        extendedTimeOut: 2000,
        showMethod: "fadeIn",
        hideMethod: "fadeOut"
    };

    var LOGIN_ROUTE = "{{ route('login.post') }}";
    var DASHBOARD_ROUTE = "{{ route('dashboard') }}";

    var ERROR_MAP = {
        USER_NOT_FOUND: {
            field: 'email',
            type: 'danger',
            title: 'Email introuvable',
            text: "Aucun compte ne correspond à cet email."
        },
        INVALID_PASSWORD: {
            field: 'mot_de_passe',
            type: 'danger',
            title: 'Mot de passe incorrect',
            text: "Le mot de passe saisi est incorrect."
        },
        ACCOUNT_INACTIVE: {
            sweetalert: true,
            icon: 'warning',
            title: 'Compte désactivé',
            text: "Votre compte a été désactivé. Contactez l'administrateur."
        },
        ERROR: {
            type: 'danger',
            title: 'Erreur technique',
            text: "Une erreur technique est survenue. Veuillez réessayer."
        }
    };

    // ============================================
    // INITIALISATION
    // ============================================

    $(document).ready(function() {
        setTimeout(function() {
            $('#global-loader').addClass('hidden');
        }, 400);

        clearData();
        bindEvents();
        checkSession();
    });

    // ============================================
    // GESTION DES ÉVÉNEMENTS
    // ============================================

    function bindEvents() {
        // Soumission du formulaire
        $('#login-form').on('submit', function(e) {
            e.preventDefault();
            handleLogin();
        });

        // Toggle password
        $('#togglePassword').on('click keydown', function(e) {
            if (e.type === 'keydown' && e.key !== 'Enter' && e.key !== ' ') return;
            e.preventDefault();
            const input = $('#mot_de_passe');
            const icon = $('#eye-icon');
            const isHidden = input.attr('type') === 'password';
            input.attr('type', isHidden ? 'text' : 'password');
            icon.toggleClass('fa-eye-slash', !isHidden).toggleClass('fa-eye', isHidden);
            $(this).attr('aria-label', isHidden ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
        });

        // Enter key
        $('#email, #mot_de_passe').on('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                handleLogin();
            }
        });

        // Validation en temps réel
        $('#email').on('blur', function() { validateField('email'); });
        $('#mot_de_passe').on('blur', function() { validateField('mot_de_passe'); });

        $('#email, #mot_de_passe').on('input', function() {
            const field = $(this).attr('id');
            const errorId = field === 'email' ? 'error-email' : 'error-password';
            const groupId = field === 'email' ? 'group-email' : 'group-password';
            clearFieldError(errorId, groupId);
            hideBanner();
        });

        // Lien mot de passe oublié
        $('#forgot-link').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                icon: 'info',
                title: 'Mot de passe oublié',
                text: "Veuillez contacter l'administrateur pour réinitialiser votre mot de passe.",
                confirmButtonColor: '#1B4D3E',
                confirmButtonText: 'Compris'
            });
        });
    }

    // ============================================
    // VALIDATION
    // ============================================

    function validateField(field) {
        const value = $('#' + field).val().trim();
        const errorId = field === 'email' ? 'error-email' : 'error-password';
        const groupId = field === 'email' ? 'group-email' : 'group-password';

        if (value === '') {
            showFieldError(errorId, groupId, field === 'email'
                ? 'L\'email est obligatoire'
                : 'Le mot de passe est obligatoire');
            return false;
        }

        if (field === 'email' && !isValidEmail(value)) {
            showFieldError(errorId, groupId, 'Veuillez saisir un email valide');
            return false;
        }

        clearFieldError(errorId, groupId);
        return true;
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function showFieldError(errorId, groupId, message) {
        $('#' + errorId + ' span').text(message);
        $('#' + errorId).show();
        $('#' + groupId).addClass('is-invalid');
    }

    function clearFieldError(errorId, groupId) {
        $('#' + errorId).hide();
        $('#' + groupId).removeClass('is-invalid');
    }

    function clearErrors() {
        clearFieldError('error-email', 'group-email');
        clearFieldError('error-password', 'group-password');
        hideBanner();
    }

    function clearData() {
        $('#email').val('');
        $('#mot_de_passe').val('');
        clearErrors();
    }

    // ============================================
    // BANDEAU D'ALERTE
    // ============================================

    function showBanner(type, title, text) {
        const banner = $('#alert-banner');
        banner.removeClass('danger warning success').addClass(type);
        $('#alert-title').text(title);
        $('#alert-text').text(text);
        banner.addClass('show');
    }

    function hideBanner() {
        $('#alert-banner').removeClass('show danger warning success');
    }

    // ============================================
    // AUTHENTIFICATION
    // ============================================

    function handleLogin() {
        const email = $('#email').val().trim();
        const password = $('#mot_de_passe').val();

        clearErrors();

        const emailValid = validateField('email');
        const passwordValid = validateField('mot_de_passe');

        if (!emailValid || !passwordValid) {
            toastr.warning('Veuillez corriger les champs en surbrillance.');
            return;
        }

        if (password.length < 6) {
            showFieldError('error-password', 'group-password', 'Le mot de passe doit contenir au moins 6 caractères.');
            toastr.warning('Le mot de passe doit contenir au moins 6 caractères.');
            return;
        }

        authentifier(email, password);
    }

    function authentifier(email, password) {
        setLoading(true);

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: LOGIN_ROUTE,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            data: {
                email: email,
                mot_de_passe: password
            },
            timeout: 10000,

            success: function(data) {
                if (data.success) {
                    handleLoginSuccess(data);
                } else {
                    setLoading(false);
                    handleBusinessError(data.code, data.message);
                }
            },

            error: function(xhr) {
                setLoading(false);
                handleAjaxError(xhr);
            }
        });
    }

    function handleLoginSuccess(data) {
        toastr.success(data.message || 'Connexion réussie !', 'Connexion réussie', {
            timeOut: 3000,
            extendedTimeOut: 1000
        });

        setRedirecting();

        setTimeout(function() {
            window.location.href = data.redirect || DASHBOARD_ROUTE;
        }, 1200);
    }

    function handleBusinessError(code, fallbackMessage) {
        const mapping = ERROR_MAP[code];

        if (mapping && mapping.sweetalert) {
            toastr.error(mapping.text, mapping.title);
            Swal.fire({
                icon: mapping.sweetalert.icon,
                title: mapping.sweetalert.title,
                text: mapping.sweetalert.text,
                confirmButtonColor: '#1B4D3E',
                confirmButtonText: "J'ai compris"
            });
            return;
        }

        if (mapping && mapping.field) {
            const errorId = mapping.field === 'email' ? 'error-email' : 'error-password';
            const groupId = mapping.field === 'email' ? 'group-email' : 'group-password';

            showFieldError(errorId, groupId, mapping.text);
            $(mapping.field === 'email' ? '#email' : '#mot_de_passe').trigger('focus');
            showBanner(mapping.type, mapping.title, mapping.text);
            shakeForm();
            toastr.error(mapping.text, mapping.title);
            return;
        }

        showBanner(
            (mapping && mapping.type) || 'danger',
            (mapping && mapping.title) || 'Connexion impossible',
            (mapping && mapping.text) || fallbackMessage || 'Email ou mot de passe incorrect.'
        );

        shakeForm();
        toastr.error((mapping && mapping.text) || fallbackMessage || 'Email ou mot de passe incorrect.');
    }

    // ============================================
    // GESTION DES ERREURS HTTP
    // ============================================

    function handleAjaxError(xhr) {
        if (xhr.status === 401) {
            try {
                const response = JSON.parse(xhr.responseText);
                handleBusinessError(response.code, response.message);
            } catch (e) {
                handleBusinessError('ERROR', 'Email ou mot de passe incorrect.');
            }
            return;
        }

        if (xhr.status === 422) {
            try {
                const response = JSON.parse(xhr.responseText);
                if (response.errors) {
                    const errors = Object.values(response.errors).flat();
                    showBanner('danger', 'Formulaire incomplet', errors.join(' '));
                    toastr.warning('Veuillez vérifier vos informations.');
                } else {
                    showBanner('danger', 'Données invalides', response.message || 'Veuillez vérifier vos informations.');
                }
            } catch (e) {
                showBanner('danger', 'Données invalides', 'Veuillez vérifier vos informations.');
            }
            shakeForm();
            return;
        }

        switch (xhr.status) {
            case 0:
                showBanner('danger', 'Connexion impossible', 'Impossible de joindre le serveur. Vérifiez votre connexion internet.');
                break;
            case 419:
                toastr.warning('Votre session a expiré.', 'Session expirée');
                Swal.fire({
                    icon: 'warning',
                    title: 'Session expirée',
                    text: 'Votre session a expiré. La page va être actualisée.',
                    confirmButtonColor: '#1B4D3E',
                    confirmButtonText: 'Actualiser'
                }).then(function() { window.location.reload(); });
                break;
            case 429:
                showBanner('warning', 'Trop de tentatives', 'Trop de tentatives de connexion. Veuillez patienter.');
                break;
            case 500:
                showBanner('danger', 'Erreur serveur', "Une erreur interne est survenue. Merci de contacter l'administrateur.");
                break;
            default:
                showBanner('danger', 'Erreur ' + xhr.status, 'Une erreur est survenue. Veuillez réessayer.');
        }
        toastr.error(showBanner.text || 'Une erreur est survenue.');
    }

    // ============================================
    // ÉTAT DE CHARGEMENT
    // ============================================

    function setLoading(state) {
        const btn = $('#btn-login');
        if (state) {
            btn.addClass('loading').prop('disabled', true);
        } else {
            btn.removeClass('loading').prop('disabled', false);
        }
    }

    function setRedirecting() {
        const btn = $('#btn-login');
        btn.addClass('loading').prop('disabled', true);
    }

    function shakeForm() {
        $('.tgf-form-panel').addClass('shake');
        setTimeout(function() { $('.tgf-form-panel').removeClass('shake'); }, 400);
    }

    // ============================================
    // VÉRIFICATION DE SESSION
    // ============================================

    function checkSession() {
        $.ajax({
            url: '{{ route("check.session") }}',
            type: 'GET',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(data) {
                if (data.authenticated) {
                    window.location.href = DASHBOARD_ROUTE;
                }
            },
            error: function() {
                // Pas de session active
            }
        });
    }
</script>

</body>
</html>
