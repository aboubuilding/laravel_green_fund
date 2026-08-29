{{-- MODAL MANIFESTATION --}}
<div class="modal fade" id="manifestationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-envelope me-2 text-tgf-accent"></i>
                    <span id="modal-title">Nouvelle manifestation</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="manifestation-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="manifestation_id" name="manifestation_id">
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="nom">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-tgf" id="nom" name="nom" placeholder="Nom" required>
                            <div class="invalid-feedback" id="error-nom"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="prenom">Prénom</label>
                            <input type="text" class="form-control form-control-tgf" id="prenom" name="prenom" placeholder="Prénom">
                            <div class="invalid-feedback" id="error-prenom"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-tgf" for="email">Email</label>
                            <input type="email" class="form-control form-control-tgf" id="email" name="email" placeholder="email@exemple.com">
                            <div class="invalid-feedback" id="error-email"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-tgf" for="telephone">Téléphone</label>
                            <input type="text" class="form-control form-control-tgf" id="telephone" name="telephone" placeholder="+228 90000000">
                            <div class="invalid-feedback" id="error-telephone"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-tgf" for="type_organisation">Type d'organisation</label>
                            <select class="form-control form-control-tgf" id="type_organisation" name="type_organisation">
                                <option value="">Sélectionner</option>
                                @foreach($typesOrganisation as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-type_organisation"></div>
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
                            <label class="form-label-tgf" for="domaine_interet_id">Domaine d'intérêt</label>
                            <select class="form-control form-control-tgf" id="domaine_interet_id" name="domaine_interet_id">
                                <option value="">Sélectionner</option>
                                @foreach($domaines as $domaine)
                                    <option value="{{ $domaine->id }}">{{ $domaine->libelle }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-domaine_interet_id"></div>
                        </div>

                        <div class="col-md-6" id="statut-group" style="display: none;">
                            <label class="form-label-tgf" for="statut_manifestation">Statut</label>
                            <select class="form-control form-control-tgf" id="statut_manifestation" name="statut_manifestation">
                                @foreach($statuts as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error-statut_manifestation"></div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label-tgf" for="message">Message</label>
                            <textarea class="form-control form-control-tgf" id="message" name="message" rows="3" placeholder="Message"></textarea>
                            <div class="invalid-feedback" id="error-message"></div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label-tgf" for="document_manifestation">Document <span class="text-danger" id="file-required">*</span></label>
                            <input type="file" class="form-control form-control-tgf" id="document_manifestation" name="document_manifestation" accept=".pdf,.doc,.docx">
                            <small class="text-muted">Formats acceptés: PDF, DOC, DOCX. Max 5 Mo</small>
                            <div class="invalid-feedback" id="error-document_manifestation"></div>

                            <div id="file-info" style="display: none;" class="mt-2">
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-file me-2"></i>
                                    <strong id="file-name"></strong>
                                    <span class="badge bg-secondary ms-2" id="file-size"></span>
                                </div>
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
