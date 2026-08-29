{{-- MODAL PROJET FINANCÉ --}}
<div class="modal fade" id="projetFinanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-star me-2 text-tgf-accent"></i>
                    <span id="modal-title">Nouveau projet financé</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="projet-finance-form">
                @csrf
                <input type="hidden" id="projet_finance_id" name="projet_finance_id">
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="projet_id">Projet <span class="text-danger">*</span></label>
                            <select class="form-control form-control-tgf" id="projet_id" name="projet_id" required>
                                <option value="">Sélectionner un projet</option>
                                @foreach($projets as $projet)
                                    <option value="{{ $projet->id }}">{{ $projet->titre }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-projet_id"></div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label-tgf" for="montant_finance">Montant financé (FCFA) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-tgf" id="montant_finance" name="montant_finance"
                                   placeholder="0" required>
                            <div class="invalid-feedback" id="error-montant_finance"></div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label-tgf" for="partenaire_id">Partenaire</label>
                            <select class="form-control form-control-tgf" id="partenaire_id" name="partenaire_id">
                                <option value="">Sélectionner un partenaire</option>
                                @foreach($partenaires as $partenaire)
                                    <option value="{{ $partenaire->id }}">{{ $partenaire->nom }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-partenaire_id"></div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label-tgf" for="annee">Année</label>
                            <input type="number" class="form-control form-control-tgf" id="annee" name="annee"
                                   placeholder="{{ date('Y') }}" min="2000" max="{{ date('Y') + 1 }}">
                            <div class="invalid-feedback" id="error-annee"></div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="mise_en_avant" name="mise_en_avant">
                                <label class="form-check-label" for="mise_en_avant">
                                    <i class="fas fa-crown text-tgf-accent"></i>
                                    Mettre en avant
                                </label>
                            </div>
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
