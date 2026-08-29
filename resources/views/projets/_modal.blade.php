{{-- MODAL PROJET --}}
<div class="modal fade" id="projetModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-diagram-project me-2 text-tgf-accent"></i>
                    <span id="modal-title">Nouveau projet</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="projet-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="projet_id" name="projet_id">
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Titre et Slug --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="titre">Titre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-tgf" id="titre" name="titre" placeholder="Titre du projet" required>
                            <div class="invalid-feedback" id="error-titre"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="slug">Slug</label>
                            <input type="text" class="form-control form-control-tgf" id="slug" name="slug" placeholder="url-personnalisee">
                            <small class="text-muted">Laissez vide pour générer automatiquement</small>
                            <div class="invalid-feedback" id="error-slug"></div>
                        </div>

                        {{-- Type et Statut --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="type_projet_id">Type de projet</label>
                            <select class="form-control form-control-tgf" id="type_projet_id" name="type_projet_id">
                                <option value="">Sélectionner</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->libelle }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-type_projet_id"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="statut_projet">Statut <span class="text-danger">*</span></label>
                            <select class="form-control form-control-tgf" id="statut_projet" name="statut_projet" required>
                                <option value="">Sélectionner</option>
                                @foreach($statuts as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-statut_projet"></div>
                        </div>

                        {{-- Localisation --}}
                        <div class="col-md-4">
                            <label class="form-label-tgf" for="region_id">Région</label>
                            <select class="form-control form-control-tgf" id="region_id" name="region_id">
                                <option value="">Sélectionner</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->nom }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-region_id"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-tgf" for="prefecture_id">Préfecture</label>
                            <select class="form-control form-control-tgf" id="prefecture_id" name="prefecture_id">
                                <option value="">Sélectionner</option>
                                @foreach($prefectures as $prefecture)
                                    <option value="{{ $prefecture->id }}">{{ $prefecture->nom }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-prefecture_id"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-tgf" for="commune_id">Commune</label>
                            <select class="form-control form-control-tgf" id="commune_id" name="commune_id">
                                <option value="">Sélectionner</option>
                                @foreach($communes as $commune)
                                    <option value="{{ $commune->id }}">{{ $commune->nom }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-commune_id"></div>
                        </div>

                        {{-- Budget et Dates --}}
                        <div class="col-md-4">
                            <label class="form-label-tgf" for="budget">Budget (FCFA)</label>
                            <input type="number" class="form-control form-control-tgf" id="budget" name="budget" placeholder="0">
                            <div class="invalid-feedback" id="error-budget"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-tgf" for="date_debut">Date de début</label>
                            <input type="date" class="form-control form-control-tgf" id="date_debut" name="date_debut">
                            <div class="invalid-feedback" id="error-date_debut"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-tgf" for="date_fin">Date de fin</label>
                            <input type="date" class="form-control form-control-tgf" id="date_fin" name="date_fin">
                            <div class="invalid-feedback" id="error-date_fin"></div>
                        </div>

                        {{-- Image --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="image">Image <span class="text-danger" id="image-required">*</span></label>
                            <input type="file" class="form-control form-control-tgf" id="image" name="image" accept="image/*">
                            <small class="text-muted">Formats acceptés: JPEG, PNG, JPG, GIF, WEBP. Max 2 Mo</small>
                            <div class="invalid-feedback" id="error-image"></div>

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
                            <textarea class="form-control form-control-tgf" id="description" name="description" rows="4" placeholder="Description du projet"></textarea>
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
