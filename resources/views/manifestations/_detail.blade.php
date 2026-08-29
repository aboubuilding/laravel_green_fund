{{-- MODAL DÉTAIL MANIFESTATION --}}
<div class="modal fade" id="detailManifestationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-file-alt me-2 text-tgf-accent"></i>
                    Détail de la manifestation
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="detail-manifestation-id">

                <div class="row g-3">
                    <div class="col-md-6">
                        <strong><i class="fas fa-user text-tgf-primary"></i> Porteur</strong>
                        <p id="detail-manifestation-nom" class="mb-3"></p>
                    </div>
                    <div class="col-md-6">
                        <strong><i class="fas fa-envelope text-tgf-primary"></i> Email</strong>
                        <p id="detail-manifestation-email" class="mb-3"></p>
                    </div>
                    <div class="col-md-6">
                        <strong><i class="fas fa-phone text-tgf-primary"></i> Téléphone</strong>
                        <p id="detail-manifestation-telephone" class="mb-3"></p>
                    </div>
                    <div class="col-md-6">
                        <strong><i class="fas fa-building text-tgf-primary"></i> Type organisation</strong>
                        <p id="detail-manifestation-type" class="mb-3"></p>
                    </div>
                    <div class="col-md-6">
                        <strong><i class="fas fa-store text-tgf-primary"></i> Guichet</strong>
                        <p id="detail-manifestation-guichet" class="mb-3"></p>
                    </div>
                    <div class="col-md-6">
                        <strong><i class="fas fa-tag text-tgf-primary"></i> Domaine d'intérêt</strong>
                        <p id="detail-manifestation-domaine" class="mb-3"></p>
                    </div>
                    <div class="col-md-12">
                        <strong><i class="fas fa-calendar text-tgf-primary"></i> Date</strong>
                        <p id="detail-manifestation-date" class="mb-3"></p>
                    </div>
                    <div class="col-md-12">
                        <strong><i class="fas fa-tag text-tgf-primary"></i> Statut</strong>
                        <p id="detail-manifestation-statut" class="mb-3"></p>
                    </div>
                    <div class="col-md-12">
                        <strong><i class="fas fa-align-left text-tgf-primary"></i> Message</strong>
                        <div class="p-3 bg-light rounded-tgf">
                            <p id="detail-manifestation-message" class="mb-0"></p>
                        </div>
                    </div>
                    <div class="col-md-12" id="detail-manifestation-document">
                        <strong><i class="fas fa-file text-tgf-primary"></i> Document</strong>
                        <div class="mt-1">
                            <a href="#" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-download"></i> Télécharger le document
                            </a>
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
