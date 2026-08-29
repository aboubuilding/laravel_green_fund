{{-- MODAL PLAINTE --}}
<div class="modal fade" id="plainteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-file-signature me-2 text-tgf-accent"></i>
                    <span id="modal-title">Nouvelle plainte</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="plainte-form">
                @csrf
                <input type="hidden" id="plainte_id" name="plainte_id">
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

                        {{-- Objet --}}
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="objet">Objet <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-tgf" id="objet" name="objet" placeholder="Objet de la plainte" required>
                            <div class="invalid-feedback" id="error-objet"></div>
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
                            <textarea class="form-control form-control-tgf" id="reponse" name="reponse" rows="3" placeholder="Réponse apportée à la plainte"></textarea>
                            <div class="invalid-feedback" id="error-reponse"></div>
                        </div>

                        {{-- Description --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="description">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-tgf" id="description" name="description" rows="4" placeholder="Description détaillée de la plainte" required></textarea>
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
