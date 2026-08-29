{{-- MODAL PROJETS ASSOCIÉS --}}
<div class="modal fade" id="projetsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-project-diagram me-2 text-tgf-accent"></i>
                    Projets associés - <span id="projets-facilite-nom"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="projets-facilite-id">

                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-associes">Projets associés</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-disponibles">Projets disponibles</button>
                    </li>
                </ul>

                <div class="tab-content mt-3">
                    <div class="tab-pane active" id="tab-associes">
                        <div class="table-responsive">
                            <table class="table table-tgf">
                                <thead>
                                <tr>
                                    <th>Projet</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody id="projets-associes-body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-disponibles">
                        <div class="table-responsive">
                            <table class="table table-tgf">
                                <thead>
                                <tr>
                                    <th>Projet</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody id="projets-disponibles-body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
