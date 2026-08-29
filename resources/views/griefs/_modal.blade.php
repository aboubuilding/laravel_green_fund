{{-- MODAL GRIEF --}}
<div class="modal fade" id="griefModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-exclamation-triangle me-2 text-tgf-accent"></i>
                    <span id="modal-title">Nouveau grief</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="grief-form">
                @csrf
                <input type="hidden" id="grief_id" name="grief_id">
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Nom --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="nom">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-tgf" id="nom" name="nom" placeholder="Nom du plaignant" required>
                            <div class="invalid-feedback" id="error-nom"></div>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="email">Email</label>
                            <input type="email" class="form-control form-control-tgf" id="email" name="email" placeholder="email@exemple.com">
                            <div class="invalid-feedback" id="error-email"></div>
                        </div>

                        {{-- Téléphone --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="telephone">Téléphone</label>
                            <input type="text" class="form-control form-control-tgf" id="telephone" name="telephone" placeholder="+228 90000000">
                            <div class="invalid-feedback" id="error-telephone"></div>
                        </div>

                        {{-- Projet --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="projet_concerne_id">Projet concerné</label>
                            <select class="form-control form-control-tgf" id="projet_concerne_id" name="projet_concerne_id">
                                <option value="">Sélectionner un projet</option>
                                @foreach($projets as $projet)
                                    <option value="{{ $projet->id }}">{{ $projet->titre }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-projet_concerne_id"></div>
                        </div>

                        {{-- Statut (modification uniquement) --}}
                        <div class="col-md-12" id="statut-group" style="display: none;">
                            <label class="form-label-tgf" for="statut">Statut</label>
                            <select class="form-control form-control-tgf" id="statut" name="statut">
                                @foreach($statuts as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-statut"></div>
                        </div>

                        {{-- Réponse (modification uniquement) --}}
                        <div class="col-md-12" id="reponse-group" style="display: none;">
                            <label class="form-label-tgf" for="reponse">Réponse</label>
                            <textarea class="form-control form-control-tgf" id="reponse" name="reponse" rows="3" placeholder="Réponse apportée au grief"></textarea>
                            <div class="invalid-feedback" id="error-reponse"></div>
                        </div>

                        {{-- Description --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="description">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-tgf" id="description" name="description" rows="4" placeholder="Description détaillée du grief" required></textarea>
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
