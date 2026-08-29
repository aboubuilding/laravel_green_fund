{{-- MODAL FACILITÉ --}}
<div class="modal fade" id="faciliteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-hand-holding-heart me-2 text-tgf-accent"></i>
                    <span id="modal-title">Nouvelle facilité</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="facilite-form">
                @csrf
                <input type="hidden" id="facilite_id" name="facilite_id">
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="nom">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-tgf" id="nom" name="nom" placeholder="Nom de la facilité" required>
                            <div class="invalid-feedback" id="error-nom"></div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label-tgf" for="slug">Slug</label>
                            <input type="text" class="form-control form-control-tgf" id="slug" name="slug" placeholder="url-personnalisee">
                            <small class="text-muted">Laissez vide pour générer automatiquement</small>
                            <div class="invalid-feedback" id="error-slug"></div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label-tgf" for="description">Description</label>
                            <textarea class="form-control form-control-tgf" id="description" name="description" rows="4" placeholder="Description de la facilité"></textarea>
                            <div class="invalid-feedback" id="error-description"></div>
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
