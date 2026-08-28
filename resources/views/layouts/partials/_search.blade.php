{{-- resources/views/layouts/partials/_search.blade.php --}}

<style>
    .search-modal {
        position: fixed;
        inset: 0;
        z-index: 10000;
        background: rgba(27, 77, 62, 0.85);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding-top: 10vh;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    .search-modal.open {
        opacity: 1;
        visibility: visible;
    }

    .search-modal-content {
        background: #fff;
        border-radius: 16px;
        max-width: 600px;
        width: 92%;
        box-shadow: 0 40px 80px rgba(27, 77, 62, 0.3);
        transform: translateY(-20px);
        transition: transform 0.3s ease;
    }
    .search-modal.open .search-modal-content {
        transform: translateY(0);
    }

    .search-modal-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 20px;
        background: #1B4D3E;
        border-radius: 16px 16px 0 0;
        border-bottom: 2px solid #F5A623;
    }

    .search-modal-header i {
        color: #F5A623;
        font-size: 1rem;
    }

    .search-modal-input {
        flex: 1;
        border: none;
        background: rgba(255,255,255,0.1);
        border-radius: 8px;
        padding: 10px 16px;
        font-size: 1rem;
        font-family: 'Source Sans 3', sans-serif;
        color: #fff;
        outline: none;
    }
    .search-modal-input::placeholder {
        color: rgba(255,255,255,0.5);
    }
    .search-modal-input:focus {
        background: rgba(255,255,255,0.18);
    }

    .search-modal-close {
        width: 36px;
        height: 36px;
        border: none;
        background: rgba(255,255,255,0.1);
        border-radius: 8px;
        color: rgba(255,255,255,0.6);
        cursor: pointer;
        font-size: 1rem;
        transition: all 0.3s;
    }
    .search-modal-close:hover {
        background: rgba(255,255,255,0.2);
        color: #fff;
        transform: rotate(90deg);
    }

    .search-modal-body {
        padding: 8px 0;
        max-height: 50vh;
        overflow-y: auto;
        font-family: 'Source Sans 3', sans-serif;
    }

    .search-empty {
        padding: 40px 20px;
        text-align: center;
        color: #6B8A7E;
    }
    .search-empty .empty-icon {
        font-size: 2.5rem;
        color: #DCE8E0;
        display: block;
        margin-bottom: 12px;
    }
    .search-empty .empty-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1B4D3E;
        margin-bottom: 4px;
    }
    .search-empty .empty-sub {
        font-size: 0.85rem;
    }
    .search-empty .empty-hint {
        display: inline-block;
        margin-top: 10px;
        padding: 4px 14px;
        background: #E8F5F0;
        border-radius: 20px;
        font-size: 0.7rem;
        color: #6B8A7E;
    }
    .search-empty .empty-hint kbd {
        background: #1B4D3E;
        color: #fff;
        padding: 1px 8px;
        border-radius: 4px;
        font-size: 0.6rem;
    }

    .search-result-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 20px;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        border-bottom: 1px solid #E8F5F0;
        transition: all 0.2s;
    }
    .search-result-item:hover {
        background: #E8F5F0;
        padding-left: 26px;
    }
    .search-result-item:last-child {
        border-bottom: none;
    }

    .search-result-icon {
        width: 36px;
        height: 36px;
        background: #1B4D3E;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #F5A623;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .search-result-info {
        flex: 1;
        min-width: 0;
    }
    .search-result-title {
        font-weight: 600;
        font-size: 0.9rem;
        color: #1B4D3E;
    }
    .search-result-title .badge {
        font-size: 0.5rem;
        font-weight: 700;
        padding: 1px 8px;
        border-radius: 20px;
        text-transform: uppercase;
        margin-left: 6px;
        color: #fff;
        background: #F5A623;
    }
    .search-result-title .badge.green { background: #2E8B57; }
    .search-result-title .badge.red { background: #DC3545; }
    .search-result-title .badge.blue { background: #2B7A9E; }
    .search-result-title .badge.purple { background: #6B46C1; }

    .search-result-sub {
        font-size: 0.75rem;
        color: #6B8A7E;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .search-modal-body::-webkit-scrollbar { width: 4px; }
    .search-modal-body::-webkit-scrollbar-track { background: #E8F5F0; }
    .search-modal-body::-webkit-scrollbar-thumb { background: #F5A623; border-radius: 4px; }

    @media (max-width: 480px) {
        .search-modal { padding-top: 4vh; }
        .search-modal-header { padding: 12px 14px; }
        .search-modal-input { font-size: 0.85rem; padding: 8px 12px; }
        .search-result-item { padding: 8px 14px; }
        .search-result-icon { width: 30px; height: 30px; font-size: 0.75rem; }
        .search-result-title { font-size: 0.8rem; }
        .search-result-sub { font-size: 0.65rem; }
        .search-empty { padding: 24px 16px; }
        .search-empty .empty-icon { font-size: 2rem; }
    }
</style>

<div class="search-modal" id="searchModal">
    <div class="search-modal-content">
        <div class="search-modal-header">
            <i class="fas fa-search"></i>
            <input type="text" class="search-modal-input" id="searchInput"
                   placeholder="Rechercher un projet, actualité, partenaire..."
                   autocomplete="off">
            <button class="search-modal-close" id="searchModalClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="search-modal-body" id="searchResults">
            <div class="search-empty">
                <span class="empty-icon"><i class="fas fa-search-plus"></i></span>
                <div class="empty-title">Recherche rapide</div>
                <div class="empty-sub">Commencez à taper pour trouver ce que vous cherchez</div>
                <div class="empty-hint"><kbd>Ctrl</kbd> + <kbd>K</kbd> pour ouvrir</div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const modal = document.getElementById('searchModal');
        const closeBtn = document.getElementById('searchModalClose');
        const input = document.getElementById('searchInput');
        const results = document.getElementById('searchResults');

        // Données de recherche
        const data = [
            { title: 'Installation solaire Kpalimé', sub: 'Énergie solaire · En cours', icon: 'fa-solar-panel', cat: 'Projet', color: 'green' },
            { title: 'Forage d\'eau Tchamba', sub: 'Eau · En cours', icon: 'fa-water', cat: 'Projet', color: 'green' },
            { title: 'Agroforesterie Plateaux', sub: 'Agroforesterie · Terminé', icon: 'fa-seedling', cat: 'Projet', color: 'green' },
            { title: 'Guichet Agriculture', sub: 'Financement agricole', icon: 'fa-tractor', cat: 'Guichet', color: 'gold' },
            { title: 'Guichet Énergie', sub: 'Financement énergies renouvelables', icon: 'fa-bolt', cat: 'Guichet', color: 'gold' },
            { title: 'Green Togo phase 3', sub: 'Programme · 500M FCFA', icon: 'fa-newspaper', cat: 'Actualité', color: 'red' },
            { title: 'Appel à projets solaire', sub: 'Zones rurales', icon: 'fa-bullhorn', cat: 'Actualité', color: 'orange' },
            { title: 'Partenariat BAD', sub: '50M de dollars', icon: 'fa-handshake', cat: 'Partenaire', color: 'blue' },
            { title: 'SOU-2026-001', sub: 'Projet solaire · En attente', icon: 'fa-file-upload', cat: 'Soumission', color: 'orange' },
            { title: 'Grief Kpalimé', sub: 'Non-respect des délais', icon: 'fa-exclamation-triangle', cat: 'Grief', color: 'red' },
            { title: 'Webinaire agroforesterie', sub: '15 mars · En ligne', icon: 'fa-calendar', cat: 'Événement', color: 'purple' },
        ];

        function search(q) {
            if (!q || q.trim() === '') return [];
            const query = q.toLowerCase().trim();
            return data.filter(item =>
                item.title.toLowerCase().includes(query) ||
                item.sub.toLowerCase().includes(query) ||
                item.cat.toLowerCase().includes(query)
            );
        }

        function render(items) {
            if (items.length === 0) {
                results.innerHTML = `
                    <div class="search-empty">
                        <span class="empty-icon"><i class="fas fa-search-minus"></i></span>
                        <div class="empty-title">Aucun résultat</div>
                        <div class="empty-sub">Aucun élément trouvé</div>
                    </div>
                `;
                return;
            }

            let html = '';
            items.forEach(item => {
                html += `
                    <a href="#" class="search-result-item">
                        <div class="search-result-icon"><i class="fas ${item.icon}"></i></div>
                        <div class="search-result-info">
                            <div class="search-result-title">
                                ${item.title}
                                <span class="badge ${item.color}">${item.cat}</span>
                            </div>
                            <div class="search-result-sub">${item.sub}</div>
                        </div>
                    </a>
                `;
            });
            results.innerHTML = html;
        }

        // Événements
        let timeout;
        input.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => render(search(this.value)), 200);
        });

        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                modal.classList.toggle('open');
                if (modal.classList.contains('open')) {
                    setTimeout(() => { input.focus(); input.select(); }, 100);
                }
            }
            if (e.key === 'Escape' && modal.classList.contains('open')) {
                modal.classList.remove('open');
            }
        });

        closeBtn.addEventListener('click', () => modal.classList.remove('open'));
        modal.addEventListener('click', function(e) {
            if (e.target === modal) modal.classList.remove('open');
        });

        // Bouton recherche dans le header
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.querySelector('[data-search-toggle]');
            if (btn) btn.addEventListener('click', () => modal.classList.add('open'));
        });

        console.log('🔍 Recherche TogoGreenFund');
    })();
</script>
