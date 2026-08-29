<div class="modal fade" id="newsletterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-envelope-open-text me-2 text-tgf-accent"></i>
                    <span id="modal-title">Ajouter un abonné</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="newsletter-form">
                @csrf
                <input type="hidden" id="newsletter_id" name="newsletter_id">

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-tgf" id="email" name="email" placeholder="exemple@domaine.com" required>
                            <div class="invalid-feedback" id="error-email"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-tgf-primary" id="btn-submit">
                        <i class="fas fa-save"></i> <span id="btn-submit-text">Ajouter</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
