{{-- MODAL CHIFFRES CLÉS --}}
<div class="modal fade" id="chiffresModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-chart-simple me-2 text-tgf-accent"></i>
                    Chiffres clés - <span id="chiffres-guichet-nom"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="chiffres-guichet-id">

                <div class="row g-3 mb-3">
                    <div class="col-md-5">
                        <input type="text" class="form-control form-control-tgf" id="chiffre-valeur" placeholder="Valeur (ex: 25+)">
                    </div>
                    <div class="col-md-5">
                        <input type="text" class="form-control form-control-tgf" id="chiffre-libelle" placeholder="Libellé (ex: Projets financés)">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-tgf-primary w-100" id="btn-add-chiffre">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-tgf">
                        <thead>
                        <tr>
                            <th>Valeur</th>
                            <th>Libellé</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="chiffres-table-body">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL ÉDITION CHIFFRE --}}
<div class="modal fade" id="editChiffreModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-edit me-2 text-tgf-accent"></i>
                    Modifier le chiffre clé
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="edit-chiffre-form">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-chiffre-id">

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="edit-chiffre-valeur">Valeur</label>
                            <input type="text" class="form-control form-control-tgf" id="edit-chiffre-valeur" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="edit-chiffre-libelle">Libellé</label>
                            <input type="text" class="form-control form-control-tgf" id="edit-chiffre-libelle" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-tgf-primary">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
