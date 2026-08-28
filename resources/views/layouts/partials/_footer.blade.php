{{-- resources/views/layouts/partials/_footer.blade.php --}}

<style>
    /* ============================================
       FOOTER TOGOGREENFUND
    ============================================ */
    :root {
        --tgf-footer-primary: #1B4D3E;
        --tgf-footer-primary-dark: #0F3328;
        --tgf-footer-primary-light: #2A7A62;
        --tgf-footer-accent: #F5A623;
        --tgf-footer-accent-light: #FFC857;
        --tgf-footer-accent-dark: #D4891A;
        --tgf-footer-muted: #6B8A7E;
        --tgf-footer-border: rgba(255, 255, 255, 0.06);
        --tgf-footer-bg: #0F3328;
    }

    .tgf-footer {
        font-family: 'Manrope', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: linear-gradient(135deg, var(--tgf-footer-primary-dark), var(--tgf-footer-primary));
        color: rgba(255, 255, 255, 0.8);
        border-top: 2px solid var(--tgf-footer-accent);
        padding: 24px 32px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        font-size: 0.85rem;
        margin-top: auto;
        width: 100%;
        position: relative;
        overflow: hidden;
    }

    /* Ligne décorative en haut avec effet vert/doré */
    .tgf-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg,
        transparent 0%,
        var(--tgf-footer-accent) 20%,
        var(--tgf-footer-accent-light) 40%,
        var(--tgf-footer-accent) 60%,
        var(--tgf-footer-primary-light) 80%,
        transparent 100%
        );
        animation: shimmer 4s ease-in-out infinite;
    }

    @keyframes shimmer {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Motif de fond subtil - Feuille stylisée */
    .tgf-footer::after {
        content: '🌿';
        position: absolute;
        right: -10px;
        bottom: -30px;
        font-size: 140px;
        opacity: 0.04;
        transform: rotate(-6deg);
        pointer-events: none;
    }

    .tgf-footer .footer-left {
        display: flex;
        flex-direction: column;
        gap: 4px;
        z-index: 1;
        position: relative;
    }

    .tgf-footer .footer-left .brand {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .tgf-footer .footer-left .brand-icon {
        width: 32px;
        height: 32px;
        background: rgba(245, 166, 35, 0.15);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: var(--tgf-footer-accent);
        border: 1px solid rgba(245, 166, 35, 0.2);
        transition: transform 0.3s ease;
    }

    .tgf-footer .footer-left .brand:hover .brand-icon {
        transform: rotate(-8deg) scale(1.05);
    }

    .tgf-footer .footer-left strong {
        color: #fff;
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: 0.3px;
        font-family: 'Manrope', sans-serif;
    }

    .tgf-footer .footer-left strong span {
        color: var(--tgf-footer-accent);
    }

    .tgf-footer .footer-left .subtitle {
        font-size: 0.7rem;
        opacity: 0.5;
        font-weight: 400;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        font-family: 'Manrope', sans-serif;
    }

    .tgf-footer .footer-left .copyright {
        font-size: 0.75rem;
        opacity: 0.6;
        font-weight: 400;
        font-family: 'Manrope', sans-serif;
    }

    .tgf-footer .footer-left .copyright i {
        color: var(--tgf-footer-accent);
        margin-right: 4px;
    }

    .tgf-footer .footer-right {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        z-index: 1;
        position: relative;
    }

    .tgf-footer .footer-right .footer-link {
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
        font-size: 0.82rem;
        display: flex;
        align-items: center;
        gap: 6px;
        position: relative;
        padding: 4px 0;
        font-family: 'Manrope', sans-serif;
    }

    .tgf-footer .footer-right .footer-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--tgf-footer-accent);
        transition: width 0.3s ease;
        border-radius: 2px;
    }

    .tgf-footer .footer-right .footer-link:hover {
        color: var(--tgf-footer-accent-light);
        transform: translateY(-2px);
    }

    .tgf-footer .footer-right .footer-link:hover::after {
        width: 100%;
    }

    .tgf-footer .footer-right .footer-link i {
        font-size: 13px;
        transition: transform 0.3s ease;
    }

    .tgf-footer .footer-right .footer-link:hover i {
        transform: scale(1.15);
    }

    .tgf-footer .footer-right .separator {
        color: rgba(255, 255, 255, 0.08);
        font-size: 0.6rem;
        user-select: none;
    }

    .tgf-footer .footer-right .version-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(245, 166, 35, 0.12);
        color: var(--tgf-footer-accent-light);
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        border: 1px solid rgba(245, 166, 35, 0.15);
        letter-spacing: 0.5px;
        font-family: 'Manrope', sans-serif;
    }

    .tgf-footer .footer-right .version-badge i {
        font-size: 11px;
    }

    .tgf-footer .footer-right .social-links {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-left: 2px;
    }

    .tgf-footer .footer-right .social-links a {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, 0.5);
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 13px;
    }

    .tgf-footer .footer-right .social-links a:hover {
        background: rgba(245, 166, 35, 0.15);
        border-color: var(--tgf-footer-accent);
        color: var(--tgf-footer-accent-light);
        transform: translateY(-3px);
        box-shadow: 0 4px 16px rgba(245, 166, 35, 0.15);
    }

    .tgf-footer .footer-right .social-links a:hover i {
        animation: socialPulse 0.4s ease;
    }

    @keyframes socialPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    /* ============================================
       RESPONSIVE
    ============================================ */
    @media (max-width: 768px) {
        .tgf-footer {
            flex-direction: column;
            text-align: center;
            padding: 20px 24px;
        }

        .tgf-footer .footer-left {
            align-items: center;
        }

        .tgf-footer .footer-left .brand {
            justify-content: center;
        }

        .tgf-footer .footer-right {
            justify-content: center;
            gap: 10px;
        }

        .tgf-footer .footer-right .separator {
            display: none;
        }

        .tgf-footer .footer-right .social-links {
            margin-left: 0;
        }

        .tgf-footer::after {
            display: none;
        }

        .tgf-footer .footer-right .version-badge {
            margin-top: 4px;
        }
    }

    @media (max-width: 480px) {
        .tgf-footer {
            padding: 16px 16px;
        }

        .tgf-footer .footer-right {
            flex-direction: column;
            gap: 6px;
        }

        .tgf-footer .footer-right .footer-link {
            font-size: 0.78rem;
        }

        .tgf-footer .footer-left .brand strong {
            font-size: 0.9rem;
        }

        .tgf-footer .footer-left .brand-icon {
            width: 28px;
            height: 28px;
            font-size: 12px;
        }

        .tgf-footer .footer-right .version-badge {
            font-size: 0.65rem;
            padding: 3px 12px;
        }
    }

    /* ============================================
       ANIMATION D'APPARITION
    ============================================ */
    .tgf-footer {
        animation: footerSlideUp 0.6s ease-out;
    }

    @keyframes footerSlideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ============================================
       DARK THEME SUPPORT
    ============================================ */
    .dark-theme .tgf-footer {
        background: linear-gradient(135deg, #0d1117, #06080a);
        border-top-color: var(--tgf-footer-accent-dark);
    }

    .dark-theme .tgf-footer::before {
        background: linear-gradient(90deg,
        transparent 0%,
        var(--tgf-footer-accent-dark) 20%,
        var(--tgf-footer-accent) 40%,
        var(--tgf-footer-accent-dark) 60%,
        var(--tgf-footer-primary-light) 80%,
        transparent 100%
        );
    }

    .dark-theme .tgf-footer .footer-right .footer-link {
        color: rgba(255, 255, 255, 0.4);
    }

    .dark-theme .tgf-footer .footer-right .footer-link:hover {
        color: var(--tgf-footer-accent-light);
    }

    .dark-theme .tgf-footer .footer-right .version-badge {
        background: rgba(245, 166, 35, 0.06);
        border-color: rgba(245, 166, 35, 0.08);
    }

    .dark-theme .tgf-footer .footer-right .social-links a {
        background: rgba(255, 255, 255, 0.02);
        border-color: rgba(255, 255, 255, 0.03);
    }

    .dark-theme .tgf-footer .footer-right .social-links a:hover {
        background: rgba(245, 166, 35, 0.08);
        border-color: var(--tgf-footer-accent-dark);
        color: var(--tgf-footer-accent);
    }

    /* ============================================
       IMPRESSION
    ============================================ */
    @media print {
        .tgf-footer {
            position: static;
            background: #f5f5f5 !important;
            color: #333 !important;
            border-top: 2px solid #ccc !important;
        }

        .tgf-footer .footer-left strong {
            color: #333 !important;
        }

        .tgf-footer .footer-left strong span {
            color: #666 !important;
        }

        .tgf-footer .footer-right .footer-link {
            color: #555 !important;
        }

        .tgf-footer .footer-right .version-badge {
            display: none;
        }

        .tgf-footer .footer-right .social-links {
            display: none;
        }

        .tgf-footer::before,
        .tgf-footer::after {
            display: none !important;
        }
    }
</style>

<footer class="tgf-footer" id="app-footer" role="contentinfo">
    <!-- Partie gauche -->
    <div class="footer-left">
        <div class="brand">
            <div class="brand-icon">
                <i class="fas fa-leaf"></i>
            </div>
            <strong>Togo<span>GreenFund</span></strong>
        </div>
        <div class="subtitle">Financement vert pour un Togo durable</div>
        <div class="copyright">
            <i class="far fa-copyright"></i> {{ date('Y') }} TogoGreenFund — Tous droits réservés
        </div>
    </div>

    <!-- Partie droite -->
    <div class="footer-right">

        <!-- Lien Accueil -->
        <a href="{{ route('dashboard') }}" class="footer-link" title="Accueil">
            <i class="fas fa-home"></i> Accueil
        </a>

        <span class="separator">|</span>

        <!-- Lien À propos -->
        <a href="#" class="footer-link" title="À propos">
            <i class="fas fa-info-circle"></i> À propos
        </a>

        <span class="separator">|</span>

        <!-- Lien Actualités -->
        <a href="#" class="footer-link" title="Actualités">
            <i class="fas fa-newspaper"></i> Actualités
        </a>

        <span class="separator">|</span>

        <!-- Lien Contact -->
        <a href="#" class="footer-link" title="Contact">
            <i class="fas fa-envelope"></i> Contact
        </a>

        <span class="separator">|</span>

        <!-- Lien Mentions légales -->
        <a href="#" class="footer-link" title="Mentions légales">
            <i class="fas fa-gavel"></i> Mentions
        </a>

        <span class="separator">|</span>

        <!-- Version -->
        <div class="version-badge">
            <i class="fas fa-code-branch"></i> v1.0.0
        </div>

        <span class="separator">|</span>

        <!-- Réseaux sociaux -->
        <div class="social-links">
            <a href="#" title="Facebook" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" title="Twitter/X" aria-label="Twitter/X" target="_blank" rel="noopener noreferrer">
                <i class="fab fa-x-twitter"></i>
            </a>
            <a href="#" title="LinkedIn" aria-label="LinkedIn" target="_blank" rel="noopener noreferrer">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="#" title="YouTube" aria-label="YouTube" target="_blank" rel="noopener noreferrer">
                <i class="fab fa-youtube"></i>
            </a>
            <a href="#" title="Instagram" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
    </div>
</footer>

{{-- Scripts pour le footer --}}
@push('js')
    <script>
        (function() {
            'use strict';

            // Animation d'entrée avec Intersection Observer
            const footer = document.getElementById('app-footer');
            if (footer) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            footer.style.animation = 'footerSlideUp 0.6s ease-out';
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });

                observer.observe(footer);

                // Gestion du clic sur les liens
                footer.querySelectorAll('.footer-link, .social-links a').forEach(link => {
                    link.addEventListener('click', function(e) {
                        if (this.getAttribute('href') === '#') {
                            e.preventDefault();
                            // Feedback visuel
                            this.style.transform = 'scale(0.95)';
                            setTimeout(() => {
                                this.style.transform = '';
                            }, 200);
                        }
                    });
                });
            }

            // Mise à jour automatique de l'année dans le copyright
            const copyright = document.querySelector('.copyright');
            if (copyright) {
                const year = new Date().getFullYear();
                copyright.innerHTML = `<i class="far fa-copyright"></i> ${year} TogoGreenFund — Tous droits réservés`;
            }

            // Animation de survol des liens sociaux avec effet d'onde
            const socialLinks = document.querySelectorAll('.social-links a');
            socialLinks.forEach(link => {
                link.addEventListener('mouseenter', function(e) {
                    const icon = this.querySelector('i');
                    if (icon) {
                        icon.style.animation = 'socialPulse 0.4s ease';
                        setTimeout(() => {
                            icon.style.animation = '';
                        }, 400);
                    }
                });
            });

            console.log('✅ Footer TogoGreenFund chargé');

        })();
    </script>
@endpush
