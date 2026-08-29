<div class="modal fade" id="documentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-file-alt me-2 text-tgf-accent"></i>
                    <span id="modal-title">Nouveau document</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="doc-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="document_id" name="document_id">
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Titre --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="titre">Titre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-tgf" id="titre" name="titre" placeholder="Titre du document" required>
                            <div class="invalid-feedback" id="error-titre"></div>
                        </div>

                        {{-- Catégorie --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="categorie_document">Catégorie <span class="text-danger">*</span></label>
                            <select class="form-control form-control-tgf" id="categorie_document" name="categorie_document" required>
                                <option value="">Sélectionner</option>
                                @foreach($categories as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-categorie_document"></div>
                        </div>

                        {{-- Type --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="type">Type <span class="text-danger">*</span></label>
                            <select class="form-control form-control-tgf" id="type" name="type" required>
                                <option value="">Sélectionner</option>
                                @foreach($types as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-type"></div>
                        </div>

                        {{-- Date --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="date">Date</label>
                            <input type="date" class="form-control form-control-tgf" id="date" name="date">
                        </div>

                        {{-- Fichier --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="fichier">Fichier <span class="text-danger" id="file-required">*</span></label>
                            <input type="file" class="form-control form-control-tgf" id="fichier" name="fichier">
                            <small class="text-muted">Format acceptés: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, JPG, PNG. Max 20 Mo</small>
                            <div class="invalid-feedback" id="error-fichier"></div>
                        </div>

                        {{-- Description --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="description">Description</label>
                            <textarea class="form-control form-control-tgf" id="description" name="description" rows="3" placeholder="Description du document"></textarea>
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
