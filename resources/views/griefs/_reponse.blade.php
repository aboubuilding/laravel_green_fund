{{-- MODAL RÉPONSE --}}
<div class="modal fade" id="reponseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-reply me-2 text-tgf-accent"></i>
                    Répondre au grief
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="reponse-form">
                @csrf
                <input type="hidden" id="reponse-grief-id">

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="reponse-text">Réponse <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-tgf" id="reponse-text" name="reponse" rows="5" placeholder="Saisissez votre réponse..." required></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-tgf-primary" id="btn-repondre">
                        <i class="fas fa-paper-plane"></i> Envoyer la réponse
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
