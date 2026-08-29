{{-- MODAL DÉTAIL SOUMISSION --}}
<div class="modal fade" id="detailSoumissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-file-alt me-2 text-tgf-accent"></i>
                    Détail de la soumission
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="detail-soumission-id">

                <div class="row g-3">
                    <div class="col-md-4">
                        <strong><i class="fas fa-hashtag text-tgf-primary"></i> Référence</strong>
                        <p id="detail-soumission-ref" class="mb-2"></p>
                    </div>
                    <div class="col-md-8">
                        <strong><i class="fas fa-tag text-tgf-primary"></i> Titre</strong>
                        <p id="detail-soumission-titre" class="mb-2"></p>
                    </div>
                    <div class="col-md-4">
                        <strong><i class="fas fa-user text-tgf-primary"></i> Porteur</strong>
                        <p id="detail-soumission-porteur" class="mb-2"></p>
                    </div>
                    <div class="col-md-4">
                        <strong><i class="fas fa-envelope text-tgf-primary"></i> Email</strong>
                        <p id="detail-soumission-email" class="mb-2"></p>
                    </div>
                    <div class="col-md-4">
                        <strong><i class="fas fa-phone text-tgf-primary"></i> Téléphone</strong>
                        <p id="detail-soumission-telephone" class="mb-2"></p>
                    </div>
                    <div class="col-md-4">
                        <strong><i class="fas fa-store text-tgf-primary"></i> Guichet</strong>
                        <p id="detail-soumission-guichet" class="mb-2"></p>
                    </div>
                    <div class="col-md-4">
                        <strong><i class="fas fa-map-marker-alt text-tgf-primary"></i> Région</strong>
                        <p id="detail-soumission-region" class="mb-2"></p>
                    </div>
                    <div class="col-md-4">
                        <strong><i class="fas fa-money-bill text-tgf-primary"></i> Montant sollicité</strong>
                        <p id="detail-soumission-montant" class="mb-2"></p>
                    </div>
                    <div class="col-md-12">
                        <strong><i class="fas fa-align-left text-tgf-primary"></i> Résumé</strong>
                        <div class="p-2 bg-light rounded">
                            <p id="detail-soumission-resume" class="mb-0"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <strong><i class="fas fa-tag text-tgf-primary"></i> Statut</strong>
                        <div id="detail-soumission-statut" class="mb-2"></div>
                    </div>
                    <div class="col-md-6">
                        <strong><i class="fas fa-chart-line text-tgf-primary"></i> Progression</strong>
                        <div id="detail-soumission-progression" class="mb-2"></div>
                    </div>
                    <div class="col-md-12">
                        <strong><i class="fas fa-history text-tgf-primary"></i> Historique</strong>
                        <div id="detail-soumission-historiques" class="mt-2"></div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Fermer
                </button>
            </div>
        </div>
    </div>
</div>
