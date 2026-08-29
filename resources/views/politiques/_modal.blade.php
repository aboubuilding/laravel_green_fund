<div class="modal fade" id="politiqueModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-book me-2 text-tgf-accent"></i>
                    <span id="modal-title">Nouvelle publication</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="politique-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="politique_id" name="politique_id">
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Titre --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="titre">Titre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-tgf" id="titre" name="titre" placeholder="Titre de la publication" required>
                            <div class="invalid-feedback" id="error-titre"></div>
                        </div>

                        {{-- Type --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="type_politique_id">Type <span class="text-danger">*</span></label>
                            <select class="form-control form-control-tgf" id="type_politique_id" name="type_politique_id" required>
                                <option value="">Sélectionner</option>
                                @foreach($types as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-type_politique_id"></div>
                        </div>

                        {{-- Date --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="date">Date</label>
                            <input type="date" class="form-control form-control-tgf" id="date" name="date">
                        </div>

                        {{-- Fichier --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="fichier">Fichier <span class="text-danger" id="file-required">*</span></label>
                            <input type="file" class="form-control form-control-tgf" id="fichier" name="fichier" accept=".pdf,.doc,.docx,.xls,.xlsx">
                            <small class="text-muted">Formats acceptés: PDF, DOC, DOCX, XLS, XLSX. Max 10 Mo</small>
                            <div class="invalid-feedback" id="error-fichier"></div>

                            {{-- Info fichier --}}
                            <div id="file-info" style="display: none;" class="mt-2">
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-file me-2"></i>
                                    <strong id="file-name"></strong>
                                    <span class="badge bg-secondary ms-2" id="file-size"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="description">Description</label>
                            <textarea class="form-control form-control-tgf" id="description" name="description" rows="3" placeholder="Description de la publication"></textarea>
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
