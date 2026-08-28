{{-- resources/views/layouts/partials/_header.blade.php --}}

<style>
    @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap');

    :root {
        --tgf-primary: #1B4D3E;
        --tgf-primary-dark: #0F3328;
        --tgf-primary-light: #2A7A62;
        --tgf-accent: #F5A623;
        --tgf-accent-light: #FFC857;
        --tgf-accent-dark: #D4891A;
        --tgf-danger: #DC3545;
        --tgf-success: #2E8B57;
        --tgf-warning: #F5A623;
        --tgf-info: #2B7A9E;
        --tgf-muted: #6B8A7E;
        --tgf-bg: #F0F5F2;
        --tgf-card-bg: #FFFFFF;
        --tgf-border: #DCE8E0;
        --tgf-shadow: 0 2px 12px rgba(27, 77, 62, 0.08);
        --tgf-shadow-hover: 0 8px 30px rgba(27, 77, 62, 0.12);
        --tgf-radius: 10px;
        --tgf-radius-lg: 16px;
        --tgf-transition: 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hbtp-root {
        font-family: 'Manrope', sans-serif;
        position: sticky;
        top: 0;
        z-index: 1000;
        width: 100%;
        background: var(--tgf-primary);
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.15);
    }

    /* ============================================
       TOP BAR
    ============================================ */
    .hbtp-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 0 24px;
        height: 60px;
        background: linear-gradient(135deg, var(--tgf-primary-dark), var(--tgf-primary));
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }

    .hbtp-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        flex-shrink: 0;
        transition: opacity var(--tgf-transition);
    }
    .hbtp-brand:hover { opacity: 0.85; }

    .hbtp-brand-icon {
        width: 40px;
        height: 40px;
        border-radius: var(--tgf-radius);
        background: linear-gradient(145deg, var(--tgf-accent-light), var(--tgf-accent));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: var(--tgf-primary);
        box-shadow: 0 4px 14px rgba(245, 166, 35, 0.3);
        transition: transform var(--tgf-transition), box-shadow var(--tgf-transition);
    }
    .hbtp-brand:hover .hbtp-brand-icon {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(245, 166, 35, 0.4);
    }

    .hbtp-brand-title {
        font-family: 'Manrope', sans-serif;
        font-size: 20px;
        font-weight: 800;
        color: #fff;
        letter-spacing: 0.3px;
        line-height: 1.1;
    }
    .hbtp-brand-sub {
        font-size: 9px;
        color: rgba(255, 255, 255, 0.45);
        letter-spacing: 1.2px;
        text-transform: uppercase;
        font-weight: 600;
        display: block;
        margin-top: 2px;
    }

    .hbtp-top-right {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }

    /* ============================================
       BOUTONS ICONES
    ============================================ */
    .hbtp-icon-btn {
        width: 38px;
        height: 38px;
        border-radius: var(--tgf-radius);
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        cursor: pointer;
        transition: all var(--tgf-transition);
        position: relative;
        text-decoration: none;
    }
    .hbtp-icon-btn:hover {
        background: rgba(255, 255, 255, 0.14);
        color: #fff;
        transform: translateY(-1px);
    }
    .hbtp-icon-btn:active {
        transform: scale(0.95);
    }

    .hbtp-notif-dot {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 8px;
        height: 8px;
        background: var(--tgf-danger);
        border-radius: 50%;
        border: 2px solid var(--tgf-primary);
        animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.5); }
        70% { box-shadow: 0 0 0 6px rgba(220, 53, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }

    .hbtp-sep {
        width: 1px;
        height: 28px;
        background: rgba(255, 255, 255, 0.08);
        margin: 0 4px;
        flex-shrink: 0;
    }

    /* ============================================
       AVATAR
    ============================================ */
    .hbtp-avatar-wrap {
        position: relative;
    }
    .hbtp-avatar-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 12px 0 6px;
        height: 38px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: var(--tgf-radius);
        cursor: pointer;
        transition: all var(--tgf-transition);
    }
    .hbtp-avatar-btn:hover {
        background: rgba(255, 255, 255, 0.12);
    }

    .hbtp-avatar-circle {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(145deg, var(--tgf-accent-light), var(--tgf-accent));
        color: var(--tgf-primary);
        font-size: 11px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1);
    }

    .hbtp-avatar-name {
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        line-height: 1;
    }
    .hbtp-avatar-role {
        font-size: 10px;
        color: rgba(255, 255, 255, 0.4);
        line-height: 1;
        margin-top: 2px;
        display: block;
        font-weight: 400;
    }
    .hbtp-avatar-caret {
        font-size: 10px;
        color: rgba(255, 255, 255, 0.4);
        margin-left: 2px;
        transition: transform var(--tgf-transition);
    }
    .hbtp-avatar-wrap.open .hbtp-avatar-caret {
        transform: rotate(180deg);
    }

    /* ============================================
       DROPDOWN UTILISATEUR
    ============================================ */
    .hbtp-user-drop {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        width: 250px;
        background: var(--tgf-card-bg);
        border-radius: var(--tgf-radius-lg);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        border: 1px solid var(--tgf-border);
        display: none;
        z-index: 9999;
        overflow: hidden;
        animation: dropIn 0.2s ease-out;
    }
    .hbtp-avatar-wrap.open .hbtp-user-drop {
        display: block;
    }

    @keyframes dropIn {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .hbtp-udrop-header {
        padding: 16px 18px;
        background: linear-gradient(135deg, #E8F5F0, #DCE8E0);
        border-bottom: 1px solid var(--tgf-border);
    }
    .hbtp-udrop-name {
        font-size: 14px;
        font-weight: 700;
        color: var(--tgf-primary);
    }
    .hbtp-udrop-email {
        font-size: 11.5px;
        color: var(--tgf-muted);
        margin-top: 2px;
    }
    .hbtp-udrop-role {
        display: inline-block;
        margin-top: 6px;
        background: var(--tgf-accent);
        color: #fff;
        font-size: 9px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .hbtp-udrop-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 18px;
        font-size: 13px;
        color: var(--tgf-primary);
        text-decoration: none;
        transition: all var(--tgf-transition);
        cursor: pointer;
        border: none;
        background: transparent;
        width: 100%;
        text-align: left;
        font-family: 'Manrope', sans-serif;
    }
    .hbtp-udrop-item:hover {
        background: #E8F5F0;
        padding-left: 24px;
    }
    .hbtp-udrop-item i {
        font-size: 15px;
        color: var(--tgf-accent-dark);
        width: 18px;
        text-align: center;
    }
    .hbtp-udrop-item.danger {
        color: var(--tgf-danger);
    }
    .hbtp-udrop-item.danger i {
        color: var(--tgf-danger);
    }
    .hbtp-udrop-item.danger:hover {
        background: #FDE8E8;
    }
    .hbtp-udrop-div {
        height: 1px;
        background: var(--tgf-border);
        margin: 4px 0;
    }

    /* ============================================
       NAV BAR
    ============================================ */
    .hbtp-nav {
        display: flex;
        align-items: center;
        padding: 0 24px;
        height: 48px;
        background: rgba(255, 255, 255, 0.03);
        border-top: 1px solid rgba(255, 255, 255, 0.04);
        overflow: visible;
    }

    .hbtp-nav-items {
        display: flex;
        align-items: center;
        gap: 2px;
        flex: 1;
        min-width: 0;
        height: 100%;
    }

    /* ============================================
       NAV ITEMS
    ============================================ */
    .hnav-item {
        position: relative;
        display: flex;
        align-items: center;
        height: 100%;
        flex-shrink: 0;
    }

    .hnav-trigger {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 16px;
        height: 100%;
        color: rgba(255, 255, 255, 0.75);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        background: transparent;
        border: none;
        font-family: 'Manrope', sans-serif;
        transition: all var(--tgf-transition);
        position: relative;
        white-space: nowrap;
    }
    .hnav-trigger i {
        font-size: 14px;
    }
    .hnav-trigger .caret {
        font-size: 10px;
        opacity: 0.6;
        transition: transform var(--tgf-transition);
    }
    .hnav-item.open .hnav-trigger .caret {
        transform: rotate(180deg);
    }

    .hnav-trigger::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%) scaleX(0);
        width: 60%;
        height: 3px;
        background: var(--tgf-accent);
        border-radius: 3px 3px 0 0;
        transition: transform var(--tgf-transition);
    }
    .hnav-item:hover .hnav-trigger::after,
    .hnav-item.open .hnav-trigger::after,
    .hnav-item.active .hnav-trigger::after {
        transform: translateX(-50%) scaleX(1);
    }

    .hnav-item:hover .hnav-trigger,
    .hnav-item.open .hnav-trigger {
        color: #fff;
        background: rgba(255, 255, 255, 0.06);
    }
    .hnav-item.active .hnav-trigger {
        color: var(--tgf-accent-light);
        background: rgba(245, 166, 35, 0.08);
    }

    .hnav-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 18px;
        height: 18px;
        padding: 0 6px;
        border-radius: 20px;
        background: var(--tgf-danger);
        color: #fff;
        font-size: 10px;
        font-weight: 800;
        line-height: 1;
        margin-left: 2px;
    }

    /* ============================================
       DROPDOWN NAV
    ============================================ */
    .hnav-drop {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 220px;
        background: var(--tgf-card-bg);
        border-radius: 0 0 var(--tgf-radius-lg) var(--tgf-radius-lg);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        border: 1px solid var(--tgf-border);
        border-top: 3px solid var(--tgf-accent);
        z-index: 99999;
        padding: 6px 0;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-4px);
        transition: all var(--tgf-transition);
        pointer-events: none;
    }
    .hnav-item.open .hnav-drop {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
        pointer-events: auto;
    }

    .hnav-drop-title {
        padding: 8px 16px 4px;
        font-size: 10px;
        text-transform: uppercase;
        color: var(--tgf-muted);
        letter-spacing: 0.8px;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .hnav-drop-title i {
        font-size: 11px;
        color: var(--tgf-accent);
    }

    .hnav-drop-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 9px 16px;
        font-size: 13px;
        font-weight: 500;
        color: var(--tgf-primary);
        text-decoration: none;
        transition: all var(--tgf-transition);
        border-left: 3px solid transparent;
        font-family: 'Manrope', sans-serif;
        cursor: pointer;
        background: transparent;
        border-right: none;
        border-top: none;
        border-bottom: none;
        width: 100%;
        text-align: left;
    }
    .hnav-drop-item:hover {
        background: #E8F5F0;
        padding-left: 22px;
        border-left-color: var(--tgf-accent);
    }
    .hnav-drop-item i {
        font-size: 14px;
        color: var(--tgf-muted);
        width: 18px;
        text-align: center;
        flex-shrink: 0;
    }
    .hnav-drop-item .hnav-mini-badge {
        margin-left: auto;
        font-size: 10px;
        font-weight: 800;
        color: #fff;
        background: var(--tgf-danger);
        border-radius: 20px;
        padding: 1px 8px;
    }
    .hnav-drop-item.urgent i {
        color: var(--tgf-danger);
    }
    .hnav-drop-item.urgent:hover {
        border-left-color: var(--tgf-danger);
    }

    .hnav-drop-div {
        height: 1px;
        background: var(--tgf-border);
        margin: 4px 0;
    }

    /* ============================================
       HAMBURGER
    ============================================ */
    .hbtp-hamburger {
        display: none;
        flex-direction: column;
        gap: 4px;
        justify-content: center;
        width: 38px;
        height: 38px;
        cursor: pointer;
        padding: 8px;
        border-radius: var(--tgf-radius);
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.08);
        flex-shrink: 0;
        transition: all var(--tgf-transition);
    }
    .hbtp-hamburger:hover {
        background: rgba(255, 255, 255, 0.12);
    }
    .hbtp-hamburger span {
        display: block;
        width: 100%;
        height: 2px;
        background: rgba(255, 255, 255, 0.85);
        border-radius: 2px;
        transition: all var(--tgf-transition);
    }
    .hbtp-hamburger.open span:nth-child(1) {
        transform: translateY(6px) rotate(45deg);
    }
    .hbtp-hamburger.open span:nth-child(2) {
        opacity: 0;
    }
    .hbtp-hamburger.open span:nth-child(3) {
        transform: translateY(-6px) rotate(-45deg);
    }

    /* ============================================
       RESPONSIVE
    ============================================ */
    @media (max-width: 1100px) {
        .hnav-trigger { font-size: 12px; padding: 0 12px; }
        .hbtp-brand-title { font-size: 17px; }
    }

    @media (max-width: 768px) {
        .hbtp-hamburger { display: flex; }
        .hbtp-brand-sub { display: none; }
        .hbtp-nav {
            height: 0;
            overflow: hidden;
            flex-direction: column;
            padding: 0;
            transition: height 0.3s ease;
            background: var(--tgf-primary-dark);
        }
        .hbtp-nav.mobile-open {
            height: auto;
            padding: 4px 0 12px;
            overflow: visible;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .hbtp-nav-items {
            flex-direction: column;
            align-items: stretch;
            gap: 0;
            height: auto;
        }

        .hnav-item {
            flex-direction: column;
            height: auto;
        }
        .hnav-trigger {
            padding: 12px 16px;
            justify-content: space-between;
            height: auto;
            width: 100%;
        }
        .hnav-trigger::after { display: none; }

        .hnav-drop {
            position: static;
            box-shadow: none;
            border: none;
            border-top: 2px solid rgba(255, 255, 255, 0.08);
            border-radius: 0;
            background: rgba(0, 0, 0, 0.15);
            transform: none !important;
            opacity: 1 !important;
            visibility: visible !important;
            display: none;
            padding: 4px 0;
        }
        .hnav-item.open .hnav-drop {
            display: block;
        }

        .hnav-drop-item {
            color: rgba(255, 255, 255, 0.9);
            border-left-color: transparent !important;
            padding: 10px 16px 10px 24px;
        }
        .hnav-drop-item:hover {
            background: rgba(0, 0, 0, 0.2);
            padding-left: 30px;
        }
        .hnav-drop-item i {
            color: rgba(255, 255, 255, 0.6);
        }
        .hnav-drop-title {
            color: rgba(255, 255, 255, 0.4);
        }
        .hnav-drop-title i {
            color: var(--tgf-accent-light);
        }
        .hnav-drop-div {
            background: rgba(255, 255, 255, 0.06);
        }
        .hnav-item.active .hnav-trigger {
            background: rgba(245, 166, 35, 0.12);
        }

        .hbtp-user-drop {
            right: -10px;
            width: 220px;
        }
        .hbtp-avatar-name { font-size: 12px; }
        .hbtp-avatar-role { font-size: 9px; }
    }

    @media (max-width: 480px) {
        .hbtp-top { padding: 0 12px; gap: 8px; height: 54px; }
        .hbtp-brand-title { font-size: 15px; }
        .hbtp-brand-icon { width: 34px; height: 34px; font-size: 15px; }
        .hbtp-avatar-name, .hbtp-avatar-role { display: none; }
        .hbtp-avatar-btn { padding: 0 6px; }
        .hbtp-icon-btn { width: 34px; height: 34px; font-size: 13px; }
        .hbtp-nav { padding: 0 12px; }
        .hbtp-sep { margin: 0 2px; }
    }

    /* ============================================
       SCROLLBAR
    ============================================ */
    ::-webkit-scrollbar { width: 4px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--tgf-accent); border-radius: 4px; }
</style>

{{-- ============================================
     HEADER TOGOGREENFUND
     ============================================ --}}

<div class="hbtp-root" id="header-top" role="banner">
    <!-- TOP BAR -->
    <div class="hbtp-top">
        <a href="{{ route('dashboard') }}" class="hbtp-brand" title="Accueil TogoGreenFund">
            <div class="hbtp-brand-icon"><i class="fas fa-leaf"></i></div>
            <div>
                <span class="hbtp-brand-title">TogoGreenFund</span>
                <span class="hbtp-brand-sub">Financement vert au Togo</span>
            </div>
        </a>

        <div class="hbtp-top-right">
            {{-- Bouton Hamburger --}}
            <button class="hbtp-hamburger" id="hbtp-hamburger" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="hbtp-main-nav">
                <span></span><span></span><span></span>
            </button>

            {{-- Recherche --}}
            <button class="hbtp-icon-btn" id="btnSearch" title="Recherche (Ctrl+K)" data-search-toggle>
                <i class="fas fa-search"></i>
            </button>

            {{-- Notifications --}}
            <a href="#" class="hbtp-icon-btn" title="Notifications">
                <i class="fas fa-bell"></i>
                <span class="hbtp-notif-dot"></span>
            </a>

            <div class="hbtp-sep"></div>

            {{-- Avatar utilisateur --}}
            <div class="hbtp-avatar-wrap" id="hbtp-avatar-wrap">
                <div class="hbtp-avatar-btn" id="hbtp-avatar-btn" role="button" tabindex="0" aria-haspopup="true" aria-expanded="false">
                    <div class="hbtp-avatar-circle">
                        {{ strtoupper(substr($headerNomComplet ?? 'AD', 0, 2)) }}
                    </div>
                    <div>
                        <span class="hbtp-avatar-name">{{ $headerNomComplet ?? 'Administrateur' }}</span>
                        <span class="hbtp-avatar-role">{{ $headerRoleLabel ?? 'Admin' }}</span>
                    </div>
                    <i class="fas fa-chevron-down hbtp-avatar-caret"></i>
                </div>

                {{-- Dropdown utilisateur --}}
                <div class="hbtp-user-drop" id="hbtp-user-drop" role="menu">
                    <div class="hbtp-udrop-header">
                        <div class="hbtp-udrop-name">{{ $headerNomComplet ?? 'Nom Prénom' }}</div>
                        <div class="hbtp-udrop-email">{{ $headerUserEmail ?? 'admin@togogreenfund.tg' }}</div>
                        <div class="hbtp-udrop-role">{{ $headerRoleLabel ?? 'Administrateur' }}</div>
                    </div>
                    <a href="#" class="hbtp-udrop-item" role="menuitem">
                        <i class="fas fa-user-circle"></i> Mon profil
                    </a>
                    <a href="#" class="hbtp-udrop-item" role="menuitem">
                        <i class="fas fa-key"></i> Changer mot de passe
                    </a>
                    <div class="hbtp-udrop-div"></div>
                    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="hbtp-udrop-item danger" role="menuitem" style="width:100%; border:none; background:transparent; text-align:left; cursor:pointer;">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- NAV BAR -->
    <nav class="hbtp-nav" id="hbtp-main-nav" aria-label="Navigation principale">
        <div class="hbtp-nav-items" id="hbtp-nav-items">

            {{-- 1. TABLEAU DE BORD --}}
            <div class="hnav-item active">
                <a href="{{ route('dashboard') }}" class="hnav-trigger">
                    <i class="fas fa-gauge-high"></i> Tableau de bord
                </a>
            </div>

            {{-- 2. ACCUEIL / CONTENU DYNAMIQUE --}}
            <div class="hnav-item">
                <a href="#" class="hnav-trigger" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-home"></i> Accueil <i class="fas fa-chevron-down caret"></i>
                </a>
                <div class="hnav-drop" role="menu">
                    <a href="#" class="hnav-drop-item"><i class="fas fa-images"></i> Diaporama (Slider)</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-chart-simple"></i> Chiffres clés</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-user-tie"></i> Mot du Coordonnateur</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-file-alt"></i> Pages</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-question-circle"></i> FAQ</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-users"></i> Équipe</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-user"></i> Membres</a>
                </div>
            </div>

            {{-- 3. PROJETS --}}
            <div class="hnav-item">
                <a href="#" class="hnav-trigger" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-diagram-project"></i> Projets <i class="fas fa-chevron-down caret"></i>
                </a>
                <div class="hnav-drop" role="menu">
                    <a href="#" class="hnav-drop-item"><i class="fas fa-list"></i> Liste des projets</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-envelope"></i> Manifestations d'intérêt</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-upload"></i> Soumissions projets</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-star"></i> Projets financés</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-check-double"></i> Réalisations</a>
                </div>
            </div>

            {{-- 4. RÉCLAMATIONS --}}
            <div class="hnav-item">
                <a href="#" class="hnav-trigger" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-exclamation-triangle"></i> Réclamations <i class="fas fa-chevron-down caret"></i>
                </a>
                <div class="hnav-drop" role="menu">
                    <a href="#" class="hnav-drop-item"><i class="fas fa-grip-lines"></i> Griefs</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-file-signature"></i> Plaintes</a>
                </div>
            </div>

            {{-- 5. GUICHETS & ACTUALITÉS --}}
            <div class="hnav-item">
                <a href="#" class="hnav-trigger" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-store"></i> Guichets & Actualités <i class="fas fa-chevron-down caret"></i>
                </a>
                <div class="hnav-drop" role="menu">
                    <div class="hnav-drop-title"><i class="fas fa-store"></i> Guichets & Facilités</div>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-store"></i> Guichets</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-hand-holding-heart"></i> Facilités</a>
                    <div class="hnav-drop-div"></div>
                    <div class="hnav-drop-title"><i class="fas fa-newspaper"></i> Actualités</div>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-newspaper"></i> Actualités</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-file-pdf"></i> Communiqués officiels</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-calendar"></i> Événements</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-info-circle"></i> Infos</a>
                </div>
            </div>

            {{-- 6. RESSOURCES --}}
            <div class="hnav-item">
                <a href="#" class="hnav-trigger" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-folder-open"></i> Ressources <i class="fas fa-chevron-down caret"></i>
                </a>
                <div class="hnav-drop" role="menu">
                    <a href="#" class="hnav-drop-item"><i class="fas fa-file-alt"></i> Documents</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-photo-video"></i> Médias</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-book"></i> Publications</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-envelope-open-text"></i> Newsletter</a>
                </div>
            </div>

            {{-- 7. PARAMÈTRES --}}
            <div class="hnav-item">
                <a href="#" class="hnav-trigger" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-gear"></i> Paramètres <i class="fas fa-chevron-down caret"></i>
                </a>
                <div class="hnav-drop" role="menu">
                    <div class="hnav-drop-title"><i class="fas fa-users-cog"></i> Utilisateurs</div>
                    <a href="{{ route('users.index') }}" class="hnav-drop-item"><i class="fas fa-users"></i> Utilisateurs</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-user-shield"></i> Rôles & permissions</a>
                    <div class="hnav-drop-div"></div>
                    <div class="hnav-drop-title"><i class="fas fa-map"></i> Localisation</div>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-map"></i> Régions</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-map-marked"></i> Préfectures</a>
                    <a href="#" class="hnav-drop-item"><i class="fas fa-city"></i> Communes</a>
                </div>
            </div>

        </div>
    </nav>
</div>

<script>
    (function () {
        'use strict';

        var navItems = document.getElementById('hbtp-nav-items');
        var isMobile = function () { return window.innerWidth <= 768; };

        function closeAll() {
            document.querySelectorAll('.hnav-item.open').forEach(function (el) {
                el.classList.remove('open');
                var t = el.querySelector(':scope > .hnav-trigger');
                if (t) t.setAttribute('aria-expanded', 'false');
            });
        }

        function openItem(item) {
            item.classList.add('open');
            var t = item.querySelector(':scope > .hnav-trigger');
            if (t) t.setAttribute('aria-expanded', 'true');
        }

        function bindItem(item) {
            if (item._btp) return;
            item._btp = true;
            var trigger = item.querySelector(':scope > .hnav-trigger');
            if (!trigger) return;

            item.addEventListener('mouseenter', function () {
                if (isMobile()) return;
                closeAll();
                openItem(item);
            });
            item.addEventListener('mouseleave', function () {
                if (isMobile()) return;
                item.classList.remove('open');
                trigger.setAttribute('aria-expanded', 'false');
            });

            trigger.addEventListener('click', function (e) {
                if (!isMobile()) return;
                e.preventDefault();
                var was = item.classList.contains('open');
                closeAll();
                if (!was) openItem(item);
            });
        }

        function bindAll() {
            document.querySelectorAll('#hbtp-nav-items > .hnav-item').forEach(bindItem);
        }

        /* ===== AVATAR ===== */
        var aWrap = document.getElementById('hbtp-avatar-wrap');
        var aBtn = document.getElementById('hbtp-avatar-btn');
        if (aWrap && aBtn) {
            aWrap.addEventListener('mouseenter', function () {
                aWrap.classList.add('open');
                aBtn.setAttribute('aria-expanded', 'true');
            });
            aWrap.addEventListener('mouseleave', function () {
                aWrap.classList.remove('open');
                aBtn.setAttribute('aria-expanded', 'false');
            });
            aBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                var o = aWrap.classList.toggle('open');
                aBtn.setAttribute('aria-expanded', String(o));
            });
            document.addEventListener('click', function (e) {
                if (!aWrap.contains(e.target)) {
                    aWrap.classList.remove('open');
                    aBtn.setAttribute('aria-expanded', 'false');
                }
            });
        }

        /* ===== HAMBURGER ===== */
        var hbg = document.getElementById('hbtp-hamburger');
        var nav = document.getElementById('hbtp-main-nav');
        if (hbg && nav) {
            hbg.addEventListener('click', function () {
                var o = nav.classList.toggle('mobile-open');
                hbg.classList.toggle('open', o);
                hbg.setAttribute('aria-expanded', String(o));
                if (o) {
                    closeAll();
                }
            });
        }

        /* ===== CTRL+K RECHERCHE ===== */
        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                var b = document.getElementById('btnSearch');
                if (b) b.click();
            }
        });

        /* ===== INIT ===== */
        bindAll();

        console.log('✅ Header TogoGreenFund chargé');
        console.log('👤 Utilisateur:', '{{ $headerNomComplet ?? "Non connecté" }}');

    })();
</script>
