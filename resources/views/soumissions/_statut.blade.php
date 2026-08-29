{{-- MODAL CHANGER STATUT --}}
<div class="modal fade" id="statutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-exchange-alt me-2 text-tgf-accent"></i>
                    Changer le statut
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="statut-form">
                @csrf
                <input type="hidden" id="statut-soumission-id">

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="statut-select">Nouveau statut</label>
                            <select class="form-control form-control-tgf" id="statut-select" name="statut">
                                @foreach($statuts as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="statut-commentaire">Commentaire</label>
                            <textarea class="form-control form-control-tgf" id="statut-commentaire" name="commentaire" rows="3" placeholder="Ajouter un commentaire..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-tgf-primary" id="btn-statut">
                        <i class="fas fa-save"></i> Changer le statut
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
