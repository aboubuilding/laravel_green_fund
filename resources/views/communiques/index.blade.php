@extends('layouts.app')

@section('title', 'Gestion des communiqués officiels')

@section('page_title', 'Gestion des communiqués')
@section('page_icon', 'fa-file-pdf')

@section('breadcrumb')
    <li class="active">Communiqués officiels</li>
@endsection

@section('page_actions')
    <button class="btn-tgf-primary btn-sm" id="btn-new-communique">
        <i class="fas fa-plus"></i> Nouveau communiqué
    </button>
@endsection

@section('contenu')

    <div class="container-fluid px-0">

        {{-- Filtres --}}
        <div class="row g-3 mb-4">
            <div class="col-md-8">
                <div class="d-flex gap-2 flex-wrap">
                    <div class="btn-group">
                        <button class="btn btn-outline-secondary btn-sm filter-status active" data-value="">Tous</button>
                        <button class="btn btn-outline-secondary btn-sm filter-status" data-value="published">
                            <i class="fas fa-check-circle text-success"></i> Publiés
                        </button>
                        <button class="btn btn-outline-secondary btn-sm filter-status" data-value="drafts">
                            <i class="fas fa-pencil text-warning"></i> Brouillons
                        </button>
                    </div>
                    <button class="btn btn-outline-secondary btn-sm" id="btn-reset-filters">
                        <i class="fas fa-undo"></i> Réinitialiser
                    </button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" id="search-communique" placeholder="Rechercher un communiqué...">
                    <button class="btn btn-outline-secondary" id="btn-search">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Statistiques --}}
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stat-card-tgf" style="border-left-color: var(--tgf-primary);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['total'] }}</p>
                            <p class="stat-label">Total communiqués</p>
                        </div>
                        <div class="stat-icon bg-tgf-primary-light">
                            <i class="fas fa-file-pdf text-tgf-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card-tgf" style="border-left-color: #2E8B57;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['published'] }}</p>
                            <p class="stat-label">Publiés</p>
                        </div>
                        <div class="stat-icon" style="background: rgba(46, 139, 87, 0.1);">
                            <i class="fas fa-check-circle text-tgf-success"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card-tgf" style="border-left-color: #F5A623;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['drafts'] }}</p>
                            <p class="stat-label">Brouillons</p>
                        </div>
                        <div class="stat-icon bg-tgf-accent-light">
                            <i class="fas fa-pencil text-tgf-accent"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau --}}
        <div class="card-tgf">
            <div class="card-header">
                <i class="fas fa-list card-title-icon"></i>
                Liste des communiqués
                <span class="badge bg-primary ms-2" id="communique-count">{{ $communiques->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-tgf mb-0">
                        <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Date publication</th>
                            <th>Résumé</th>
                            <th>Document</th>
                            <th>Statut</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="communique-table-body">
                        @include('communiques._rows', ['communiques' => $communiques])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL COMMUNIQUÉ --}}
    @include('communiques._modal')

@endsection

@push('js')
    <script>
        $(document).ready(function() {

            // ============================================
            // OUVERTURE MODAL - CRÉATION
            // ============================================
            $('#btn-new-communique').on('click', function() {
                resetModal();
                $('#modal-title').text('Nouveau communiqué');
                $('#btn-submit-text').text('Créer');
                $('#form-method').val('POST');
                $('#communique_id').val('');
                $('#communique-form')[0].reset();
                $('#communique-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#document-required').show();
                $('#document').prop('required', true);
                $('#file-info').hide();
                $('#communiqueModal').modal('show');
            });

            // ============================================
            // OUVERTURE MODAL - ÉDITION
            // ============================================
            $(document).on('click', '.btn-edit-communique', function() {
                const id = $(this).data('id');

                resetModal();
                $('#modal-title').text('Modifier le communiqué');
                $('#btn-submit-text').text('Mettre à jour');
                $('#form-method').val('PUT');

                $.ajax({
                    url: '/communiques/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        $('#communique_id').val(data.id);
                        $('#titre').val(data.titre);
                        $('#date_publication').val(data.date_publication);
                        $('#resume').val(data.resume);
                        $('#document-required').hide();
                        $('#document').prop('required', false);

                        if (data.document_url) {
                            $('#file-info').show();
                            $('#file-name').text(data.document_url.split('/').pop());
                        } else {
                            $('#file-info').hide();
                        }

                        $('#communique-form .is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').removeClass('show').empty();
                        $('#communiqueModal').modal('show');
                    },
                    error: function() {
                        toastr.error('Erreur lors du chargement des données.');
                    }
                });
            });

            // ============================================
            // SOUMISSION DU FORMULAIRE (AJAX)
            // ============================================
            $('#communique-form').on('submit', function(e) {
                e.preventDefault();

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();

                const form = $(this);
                const formData = new FormData(this);
                const id = $('#communique_id').val();
                const url = id ? '/communiques/' + id : '/communiques';

                if (id) {
                    formData.append('_method', 'PUT');
                }

                const btn = $('#btn-submit');
                const originalText = btn.html();
                btn.html('<i class="fas fa-spinner fa-spin"></i> Chargement...').prop('disabled', true);

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        btn.html(originalText).prop('disabled', false);

                        if (response.success) {
                            toastr.success(response.message);
                            $('#communiqueModal').modal('hide');
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        }
                    },
                    error: function(xhr) {
                        btn.html(originalText).prop('disabled', false);

                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            Object.keys(errors).forEach(function(key) {
                                const field = $('#' + key);
                                const errorDiv = $('#error-' + key);
                                if (field.length) {
                                    field.addClass('is-invalid');
                                    errorDiv.text(errors[key][0]).addClass('show');
                                }
                            });
                            toastr.warning('Veuillez corriger les erreurs.');
                        } else {
                            toastr.error(xhr.responseJSON?.message || 'Une erreur est survenue.');
                        }
                    }
                });
            });

            // ============================================
            // PUBLIER / DÉPUBLIER
            // ============================================
            $(document).on('click', '.btn-publish', function() {
                const id = $(this).data('id');
                const isPublished = $(this).data('published') === 1;
                const btn = $(this);

                const title = isPublished ? 'Retirer de la publication' : 'Publier';
                const text = isPublished ? 'Ce communiqué sera retiré du site.' : 'Ce communiqué sera visible sur le site.';

                Swal.fire({
                    title: 'Confirmer',
                    html: `<strong>${title}</strong><br><small class="text-muted">${text}</small>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: isPublished ? '#F5A623' : '#2E8B57',
                    cancelButtonColor: '#6B8A7E',
                    confirmButtonText: isPublished ? 'Oui, retirer' : 'Oui, publier',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const url = isPublished ? '/communiques/' + id + '/unpublish' : '/communiques/' + id + '/publish';

                        btn.prop('disabled', true);
                        btn.html('<i class="fas fa-spinner fa-spin"></i>');

                        $.ajax({
                            url: url,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            success: function(response) {
                                if (response.success) {
                                    toastr.success(response.message);
                                    setTimeout(function() {
                                        location.reload();
                                    }, 500);
                                }
                            },
                            error: function() {
                                toastr.error('Erreur lors de l\'opération.');
                                btn.prop('disabled', false);
                                btn.html(isPublished ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>');
                            }
                        });
                    }
                });
            });

            // ============================================
            // SUPPRESSION (SweetAlert + AJAX)
            // ============================================
            $(document).on('click', '.btn-delete-communique', function() {
                const id = $(this).data('id');
                const titre = $(this).data('titre');
                const btn = $(this);

                Swal.fire({
                    title: 'Confirmer la suppression',
                    html: `Voulez-vous vraiment supprimer <strong>${titre}</strong> ?<br><small class="text-muted">Cette action est irréversible.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DC3545',
                    cancelButtonColor: '#6B8A7E',
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        btn.prop('disabled', true);
                        btn.html('<i class="fas fa-spinner fa-spin"></i>');

                        $.ajax({
                            url: '/communiques/' + id,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            success: function(response) {
                                if (response.success) {
                                    toastr.success(response.message);
                                    setTimeout(function() {
                                        location.reload();
                                    }, 500);
                                }
                            },
                            error: function() {
                                toastr.error('Erreur lors de la suppression.');
                                btn.prop('disabled', false);
                                btn.html('<i class="fas fa-trash"></i>');
                            }
                        });
                    }
                });
            });

            // ============================================
            // APERÇU DU DOCUMENT
            // ============================================
            $('#document').on('change', function() {
                const file = this.files[0];
                if (file) {
                    $('#file-info').show();
                    $('#file-name').text(file.name);
                    $('#file-size').text((file.size / 1024).toFixed(1) + ' Ko');
                } else {
                    $('#file-info').hide();
                }
            });

            // ============================================
            // FILTRES
            // ============================================
            function applyFilters() {
                const statut = $('.filter-status.active').data('value') || '';

                $.ajax({
                    url: '/communiques/filter',
                    method: 'GET',
                    data: { statut: statut },
                    success: function(response) {
                        if (response.success) {
                            $('#communique-table-body').html(response.html);
                            $('#communique-count').text(response.count);
                        }
                    }
                });
            }

            $('.filter-status').on('click', function() {
                $('.filter-status').removeClass('active');
                $(this).addClass('active');
                applyFilters();
            });

            $('#btn-reset-filters').on('click', function() {
                $('.filter-status').removeClass('active');
                $('.filter-status[data-value=""]').addClass('active');
                $('#search-communique').val('');
                applyFilters();
            });

            // ============================================
            // RECHERCHE
            // ============================================
            $('#btn-search').on('click', function() {
                const query = $('#search-communique').val();

                if (!query) {
                    applyFilters();
                    return;
                }

                $.ajax({
                    url: '/communiques/search',
                    method: 'GET',
                    data: { q: query },
                    success: function(response) {
                        if (response.success) {
                            $('#communique-table-body').html(response.html);
                            $('#communique-count').text(response.count);
                        }
                    }
                });
            });

            $('#search-communique').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btn-search').click();
                }
            });

            // ============================================
            // RESET MODAL
            // ============================================
            function resetModal() {
                $('#communique-form')[0].reset();
                $('#communique-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#communique_id').val('');
                $('#form-method').val('POST');
                $('#file-info').hide();
                $('#file-name').text('');
                $('#file-size').text('');
            }

        });
    </script>
@endpush
