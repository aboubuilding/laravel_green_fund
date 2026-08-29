<div class="modal fade" id="communiqueModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-file-pdf me-2 text-tgf-accent"></i>
                    <span id="modal-title">Nouveau communiqué</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="communique-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="communique_id" name="communique_id">
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Titre --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="titre">Titre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-tgf" id="titre" name="titre" placeholder="Titre du communiqué" required>
                            <div class="invalid-feedback" id="error-titre"></div>
                        </div>

                        {{-- Date de publication --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="date_publication">Date de publication</label>
                            <input type="date" class="form-control form-control-tgf" id="date_publication" name="date_publication">
                            <div class="invalid-feedback" id="error-date_publication"></div>
                        </div>

                        {{-- Document PDF --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="document">Document PDF <span class="text-danger" id="document-required">*</span></label>
                            <input type="file" class="form-control form-control-tgf" id="document" name="document" accept=".pdf">
                            <small class="text-muted">Format accepté: PDF. Max 5 Mo</small>
                            <div class="invalid-feedback" id="error-document"></div>

                            {{-- Info fichier --}}
                            <div id="file-info" style="display: none;" class="mt-2">
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-file-pdf me-2"></i>
                                    <strong id="file-name"></strong>
                                    <span class="badge bg-secondary ms-2" id="file-size"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Résumé --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="resume">Résumé</label>
                            <textarea class="form-control form-control-tgf" id="resume" name="resume" rows="4" placeholder="Résumé du communiqué"></textarea>
                            <div class="invalid-feedback" id="error-resume"></div>
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
