<div class="modal fade" id="campaignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-paper-plane me-2 text-tgf-accent"></i>
                    Envoyer une campagne
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="campaign-form">
                @csrf

                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Sujet --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="sujet">Sujet <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-tgf" id="sujet" name="sujet" placeholder="Sujet de l'email" required>
                            <div class="invalid-feedback" id="error-sujet"></div>
                        </div>

                        {{-- Destinataires --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="destinataires">Destinataires <span class="text-danger">*</span></label>
                            <select class="form-control form-control-tgf" id="destinataires" name="destinataires" required>
                                <option value="actifs">Abonnés actifs</option>
                                <option value="tous">Tous les abonnés</option>
                            </select>
                            <div class="invalid-feedback" id="error-destinataires"></div>
                        </div>

                        {{-- Contenu --}}
                        <div class="col-md-12">
                            <label class="form-label-tgf" for="contenu">Contenu <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-tgf" id="contenu" name="contenu" rows="8" placeholder="Saisissez le contenu de votre email..." required></textarea>
                            <div class="invalid-feedback" id="error-contenu"></div>
                            <small class="text-muted">Utilisez du texte simple. L'email sera envoyé en format texte brut.</small>
                        </div>

                        {{-- Stats destinataires --}}
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <span id="destinataires-count">Chargement du nombre de destinataires...</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-tgf-primary" id="btn-send">
                        <i class="fas fa-paper-plane"></i> Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            // Mise à jour du nombre de destinataires
            $('#destinataires').on('change', function() {
                const value = $(this).val();
                $.ajax({
                    url: '{{ route("newsletter.stats") }}',
                    method: 'GET',
                    success: function(response) {
                        const count = value === 'tous' ? response.total : response.active;
                        $('#destinataires-count').text(count + ' destinataire(s)');
                    }
                });
            });

            // Chargement initial
            $('#destinataires').trigger('change');
        });
    </script>
@endpush
