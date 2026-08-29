{{-- MODAL EMAIL --}}
<div class="modal fade" id="emailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-reply me-2 text-tgf-accent"></i>
                    Envoyer un email
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="email-form">
                @csrf
                <input type="hidden" id="email-manifestation-id">

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label-tgf">Destinataire</label>
                            <p class="form-control-static" id="email-destinataire"></p>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="email-sujet">Sujet <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-tgf" id="email-sujet" name="sujet" placeholder="Sujet de l'email" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="email-contenu">Contenu <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-tgf" id="email-contenu" name="contenu" rows="8" placeholder="Saisissez le contenu de votre email..." required></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-tgf-primary" id="btn-email">
                        <i class="fas fa-paper-plane"></i> Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
