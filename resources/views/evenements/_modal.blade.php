<div class="modal fade" id="evenementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-calendar me-2 text-tgf-accent"></i>
                    <span id="modal-title">Nouvel événement</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="evenement-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="evenement_id" name="evenement_id">
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Titre --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="titre">Titre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-tgf" id="titre" name="titre" placeholder="Titre de l'événement" required>
                            <div class="invalid-feedback" id="error-titre"></div>
                        </div>

                        {{-- Type --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="type_evenement">Type <span class="text-danger">*</span></label>
                            <select class="form-control form-control-tgf" id="type_evenement" name="type_evenement" required>
                                <option value="">Sélectionner</option>
                                @foreach($types as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-type_evenement"></div>
                        </div>

                        {{-- Date --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="date_evenement">Date</label>
                            <input type="date" class="form-control form-control-tgf" id="date_evenement" name="date_evenement">
                            <div class="invalid-feedback" id="error-date_evenement"></div>
                        </div>

                        {{-- Lieu --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="lieu">Lieu</label>
                            <input type="text" class="form-control form-control-tgf" id="lieu" name="lieu" placeholder="Lieu de l'événement">
                            <div class="invalid-feedback" id="error-lieu"></div>
                        </div>

                        {{-- Image --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="image">Image <span class="text-danger" id="image-required">*</span></label>
                            <input type="file" class="form-control form-control-tgf" id="image" name="image" accept="image/*">
                            <small class="text-muted">Formats acceptés: JPEG, PNG, JPG, GIF, WEBP. Max 2 Mo</small>
                            <div class="invalid-feedback" id="error-image"></div>

                            {{-- Aperçu image --}}
                            <div id="image-preview-container" style="display: none;" class="mt-2">
                                <label class="form-label-tgf">Aperçu</label>
                                <div style="max-height: 150px; overflow: hidden; border-radius: 8px; background: #f0f5f2;">
                                    <img id="image-preview" src="" alt="Aperçu" style="width: 100%; max-height: 150px; object-fit: cover;">
                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="description">Description</label>
                            <textarea class="form-control form-control-tgf" id="description" name="description" rows="4" placeholder="Description de l'événement"></textarea>
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
