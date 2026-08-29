{{-- MODAL DÉTAIL GRIEF --}}
<div class="modal fade" id="detailGriefModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-file-alt me-2 text-tgf-accent"></i>
                    Détail du grief
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="detail-grief-id">

                <div class="row g-3">
                    <div class="col-md-6">
                        <strong><i class="fas fa-user text-tgf-primary"></i> Nom</strong>
                        <p id="detail-grief-nom" class="mb-3"></p>
                    </div>
                    <div class="col-md-6">
                        <strong><i class="fas fa-envelope text-tgf-primary"></i> Email</strong>
                        <p id="detail-grief-email" class="mb-3"></p>
                    </div>
                    <div class="col-md-6">
                        <strong><i class="fas fa-phone text-tgf-primary"></i> Téléphone</strong>
                        <p id="detail-grief-telephone" class="mb-3"></p>
                    </div>
                    <div class="col-md-6">
                        <strong><i class="fas fa-project-diagram text-tgf-primary"></i> Projet</strong>
                        <p id="detail-grief-projet" class="mb-3"></p>
                    </div>
                    <div class="col-md-12">
                        <strong><i class="fas fa-calendar text-tgf-primary"></i> Date</strong>
                        <p id="detail-grief-date" class="mb-3"></p>
                    </div>
                    <div class="col-md-12">
                        <strong><i class="fas fa-tag text-tgf-primary"></i> Statut</strong>
                        <p id="detail-grief-statut" class="mb-3"></p>
                    </div>
                    <div class="col-md-12">
                        <strong><i class="fas fa-align-left text-tgf-primary"></i> Description</strong>
                        <div class="p-3 bg-light rounded-tgf">
                            <p id="detail-grief-description" class="mb-0"></p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <strong><i class="fas fa-reply text-tgf-primary"></i> Réponse</strong>
                        <div class="p-3 bg-light rounded-tgf">
                            <p id="detail-grief-reponse" class="mb-0"></p>
                        </div>
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
