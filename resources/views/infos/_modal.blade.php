<div class="modal fade" id="infoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-info-circle me-2 text-tgf-accent"></i>
                    <span id="modal-title">Nouvelle info</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="info-form">
                @csrf
                <input type="hidden" id="info_id" name="info_id">
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Titre --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="titre">Titre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-tgf" id="titre" name="titre" placeholder="Titre de l'info" required>
                            <div class="invalid-feedback" id="error-titre"></div>
                        </div>

                        {{-- Date --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="date">Date</label>
                            <input type="date" class="form-control form-control-tgf" id="date" name="date">
                            <div class="invalid-feedback" id="error-date"></div>
                        </div>

                        {{-- Contenu --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="contenu">Contenu</label>
                            <textarea class="form-control form-control-tgf" id="contenu" name="contenu" rows="4" placeholder="Contenu de l'info"></textarea>
                            <div class="invalid-feedback" id="error-contenu"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-tgf-primary" id="btn-submit">
                        <i class="fas fa-save"></i> <span id="btn-submit-text">Créer</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
