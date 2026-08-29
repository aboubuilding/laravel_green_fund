<div class="modal fade" id="actualiteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-newspaper me-2 text-tgf-accent"></i>
                    <span id="modal-title">Nouvelle actualité</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="actualite-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="actualite_id" name="actualite_id">
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Titre --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="titre">Titre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-tgf" id="titre" name="titre" placeholder="Titre de l'actualité" required>
                            <div class="invalid-feedback" id="error-titre"></div>
                        </div>

                        {{-- Slug --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="slug">Slug</label>
                            <input type="text" class="form-control form-control-tgf" id="slug" name="slug" placeholder="url-personnalisee">
                            <small class="text-muted">Laissez vide pour générer automatiquement</small>
                            <div class="invalid-feedback" id="error-slug"></div>
                        </div>

                        {{-- Statut --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="statut_actualite">Statut <span class="text-danger">*</span></label>
                            <select class="form-control form-control-tgf" id="statut_actualite" name="statut_actualite" required>
                                <option value="">Sélectionner</option>
                                @foreach($statuts as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-statut_actualite"></div>
                        </div>

                        {{-- Date de publication --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="date_publication">Date de publication</label>
                            <input type="date" class="form-control form-control-tgf" id="date_publication" name="date_publication">
                            <div class="invalid-feedback" id="error-date_publication"></div>
                        </div>

                        {{-- Image --}}
                        <div class="col-md-6">
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

                        {{-- Extrait --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="extrait">Extrait</label>
                            <textarea class="form-control form-control-tgf" id="extrait" name="extrait" rows="2" placeholder="Résumé de l'actualité (laissez vide pour génération automatique)"></textarea>
                            <div class="invalid-feedback" id="error-extrait"></div>
                        </div>

                        {{-- Contenu --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="contenu">Contenu <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-tgf" id="contenu" name="contenu" rows="8" placeholder="Contenu de l'actualité (HTML autorisé)" required></textarea>
                            <div class="invalid-feedback" id="error-contenu"></div>
                            <small class="text-muted">Vous pouvez utiliser des balises HTML pour mettre en forme votre texte.</small>
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
