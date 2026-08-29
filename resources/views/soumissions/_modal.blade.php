{{-- MODAL SOUMISSION --}}
<div class="modal fade" id="soumissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-upload me-2 text-tgf-accent"></i>
                    <span id="modal-title">Nouvelle soumission</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="soumission-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="soumission_id" name="soumission_id">
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Informations porteur --}}
                        <h6 class="fw-600 text-tgf-primary"><i class="fas fa-user me-2 text-tgf-accent"></i> Informations du porteur</h6>
                        <div class="col-md-4">
                            <label class="form-label-tgf" for="porteur_nom">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-tgf" id="porteur_nom" name="porteur_nom" placeholder="Nom" required>
                            <div class="invalid-feedback" id="error-porteur_nom"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-tgf" for="porteur_fonction">Fonction <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-tgf" id="porteur_fonction" name="porteur_fonction" placeholder="Fonction" required>
                            <div class="invalid-feedback" id="error-porteur_fonction"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-tgf" for="porteur_email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-tgf" id="porteur_email" name="porteur_email" placeholder="email@exemple.com" required>
                            <div class="invalid-feedback" id="error-porteur_email"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-tgf" for="porteur_telephone">Téléphone</label>
                            <input type="text" class="form-control form-control-tgf" id="porteur_telephone" name="porteur_telephone" placeholder="+228 90000000">
                            <div class="invalid-feedback" id="error-porteur_telephone"></div>
                        </div>

                        {{-- Informations projet --}}
                        <h6 class="fw-600 text-tgf-primary mt-3"><i class="fas fa-diagram-project me-2 text-tgf-accent"></i> Informations du projet</h6>
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="titre_projet">Titre du projet <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-tgf" id="titre_projet" name="titre_projet" placeholder="Titre du projet" required>
                            <div class="invalid-feedback" id="error-titre_projet"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="guichet_id">Guichet</label>
                            <select class="form-control form-control-tgf" id="guichet_id" name="guichet_id">
                                <option value="">Sélectionner</option>
                                @foreach($guichets as $guichet)
                                    <option value="{{ $guichet->id }}">{{ $guichet->nom }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-guichet_id"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="montant_sollicite">Montant sollicité (FCFA)</label>
                            <input type="number" class="form-control form-control-tgf" id="montant_sollicite" name="montant_sollicite" placeholder="0">
                            <div class="invalid-feedback" id="error-montant_sollicite"></div>
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
                            <label class="form-label-tgf" for="date_demarrage">Date de démarrage</label>
                            <input type="date" class="form-control form-control-tgf" id="date_demarrage" name="date_demarrage">
                            <div class="invalid-feedback" id="error-date_demarrage"></div>
                        </div>

                        {{-- Documents --}}
                        <h6 class="fw-600 text-tgf-primary mt-3"><i class="fas fa-file me-2 text-tgf-accent"></i> Documents</h6>
                        <div class="col-md-6 doc-container">
                            <label class="form-label-tgf" for="doc_statut">Statut juridique</label>
                            <input type="file" class="form-control form-control-tgf doc-file-input" id="doc_statut" name="doc_statut" accept=".pdf,.doc,.docx">
                            <div class="file-info" style="display:none;">
                                <span class="file-name"></span> (<span class="file-size"></span>)
                            </div>
                        </div>
                        <div class="col-md-6 doc-container">
                            <label class="form-label-tgf" for="attestation_fiscal">Attestation fiscale</label>
                            <input type="file" class="form-control form-control-tgf doc-file-input" id="attestation_fiscal" name="attestation_fiscal" accept=".pdf,.doc,.docx">
                            <div class="file-info" style="display:none;">
                                <span class="file-name"></span> (<span class="file-size"></span>)
                            </div>
                        </div>
                        <div class="col-md-6 doc-container">
                            <label class="form-label-tgf" for="doc_budget">Document budget</label>
                            <input type="file" class="form-control form-control-tgf doc-file-input" id="doc_budget" name="doc_budget" accept=".pdf,.doc,.docx,.xls,.xlsx">
                            <div class="file-info" style="display:none;">
                                <span class="file-name"></span> (<span class="file-size"></span>)
                            </div>
                        </div>
                        <div class="col-md-6 doc-container">
                            <label class="form-label-tgf" for="autre_document">Autre document</label>
                            <input type="file" class="form-control form-control-tgf doc-file-input" id="autre_document" name="autre_document" accept=".pdf,.doc,.docx">
                            <div class="file-info" style="display:none;">
                                <span class="file-name"></span> (<span class="file-size"></span>)
                            </div>
                        </div>

                        {{-- Résumé --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="resume_projet">Résumé du projet</label>
                            <textarea class="form-control form-control-tgf" id="resume_projet" name="resume_projet" rows="3" placeholder="Résumé du projet"></textarea>
                            <div class="invalid-feedback" id="error-resume_projet"></div>
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
