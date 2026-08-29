<div class="modal fade" id="mediaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-photo-video me-2 text-tgf-accent"></i>
                    <span id="modal-title">Ajouter un média</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="media-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="media_id" name="media_id">
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Type --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="type_media">Type <span class="text-danger">*</span></label>
                            <select class="form-control form-control-tgf" id="type_media" name="type_media" required>
                                <option value="">Sélectionner</option>
                                @foreach($types as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-type_media"></div>
                        </div>

                        {{-- Date --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="date">Date</label>
                            <input type="date" class="form-control form-control-tgf" id="date" name="date">
                        </div>

                        {{-- Fichier --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="fichier">Fichier <span class="text-danger" id="file-required">*</span></label>
                            <input type="file" class="form-control form-control-tgf" id="fichier" name="fichier" accept="image/*,video/*">
                            <small class="text-muted">Formats acceptés: JPG, PNG, GIF, WEBP, MP4, AVI, MOV, WMV. Max 50 Mo</small>
                            <div class="invalid-feedback" id="error-fichier"></div>
                        </div>

                        {{-- Aperçu --}}
                        <div class="col-md-12" id="preview-container" style="display: none;">
                            <label class="form-label-tgf">Aperçu</label>
                            <div style="max-height: 300px; overflow: hidden; border-radius: 8px; background: #f0f5f2;">
                                <img id="preview-image" src="" alt="Aperçu" style="width: 100%; max-height: 300px; object-fit: contain;">
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="description">Description</label>
                            <textarea class="form-control form-control-tgf" id="description" name="description" rows="3" placeholder="Description du média"></textarea>
                            <div class="invalid-feedback" id="error-description"></div>
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
