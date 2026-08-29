@extends('layouts.app')

@section('title', 'Gestion des publications')

@section('page_title', 'Gestion des publications')
@section('page_icon', 'fa-book')

@section('breadcrumb')
    <li class="active">Publications</li>
@endsection

@section('page_actions')
    <button class="btn-tgf-primary btn-sm" id="btn-new-politique">
        <i class="fas fa-plus"></i> Nouvelle publication
    </button>
@endsection

@section('contenu')

    <div class="container-fluid px-0">

        {{-- Filtres --}}
        <div class="row g-3 mb-4">
            <div class="col-md-8">
                <div class="d-flex gap-2 flex-wrap">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-filter"></i> Type
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item filter-type active" href="#" data-value="">Tous</a></li>
                            @foreach($types as $value => $label)
                                <li><a class="dropdown-item filter-type" href="#" data-value="{{ $value }}">{{ $label }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-eye"></i> Statut
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item filter-status active" href="#" data-value="">Tous</a></li>
                            <li><a class="dropdown-item filter-status" href="#" data-value="published">Publiés</a></li>
                            <li><a class="dropdown-item filter-status" href="#" data-value="drafts">Brouillons</a></li>
                        </ul>
                    </div>

                    <button class="btn btn-outline-secondary btn-sm" id="btn-reset-filters">
                        <i class="fas fa-undo"></i> Réinitialiser
                    </button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" id="search-politique" placeholder="Rechercher une publication...">
                    <button class="btn btn-outline-secondary" id="btn-search">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Statistiques --}}
        <div class="row g-4 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: var(--tgf-primary);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['total'] }}</p>
                            <p class="stat-label">Total publications</p>
                        </div>
                        <div class="stat-icon bg-tgf-primary-light">
                            <i class="fas fa-book text-tgf-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
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

            <div class="col-md-3 col-sm-6">
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

            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #6B46C1;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['recent'] }}</p>
                            <p class="stat-label">Récents (5 derniers)</p>
                        </div>
                        <div class="stat-icon" style="background: rgba(107, 70, 193, 0.1);">
                            <i class="fas fa-clock" style="color: #6B46C1;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau --}}
        <div class="card-tgf">
            <div class="card-header">
                <i class="fas fa-list card-title-icon"></i>
                Liste des publications
                <span class="badge bg-primary ms-2" id="politique-count">{{ $politiques->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-tgf mb-0" id="politique-table">
                        <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Type</th>
                            <th>Fichier</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="politique-table-body">
                        @include('politiques._rows', ['politiques' => $politiques])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL PUBLICATION --}}
    @include('politiques._modal')

@endsection

@push('js')
    <script>
        $(document).ready(function() {

            // ============================================
            // OUVERTURE MODAL - CRÉATION
            // ============================================
            $('#btn-new-politique').on('click', function() {
                resetModal();
                $('#modal-title').text('Nouvelle publication');
                $('#btn-submit-text').text('Créer');
                $('#form-method').val('POST');
                $('#politique_id').val('');
                $('#politique-form')[0].reset();
                $('#politique-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#file-required').show();
                $('#fichier').prop('required', true);
                $('#politiqueModal').modal('show');
            });

            // ============================================
            // OUVERTURE MODAL - ÉDITION
            // ============================================
            $(document).on('click', '.btn-edit-politique', function() {
                const id = $(this).data('id');

                resetModal();
                $('#modal-title').text('Modifier la publication');
                $('#btn-submit-text').text('Mettre à jour');
                $('#form-method').val('PUT');

                $.ajax({
                    url: '/politiques/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        $('#politique_id').val(data.id);
                        $('#titre').val(data.titre);
                        $('#type_politique_id').val(data.type_politique_id);
                        $('#date').val(data.date);
                        $('#description').val(data.description);
                        $('#file-required').hide();
                        $('#fichier').prop('required', false);
                        $('#politique-form .is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').removeClass('show').empty();
                        $('#politiqueModal').modal('show');
                    },
                    error: function() {
                        toastr.error('Erreur lors du chargement des données.');
                    }
                });
            });

            // ============================================
            // SOUMISSION DU FORMULAIRE (AJAX)
            // ============================================
            $('#politique-form').on('submit', function(e) {
                e.preventDefault();

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();

                const form = $(this);
                const formData = new FormData(this);
                const id = $('#politique_id').val();
                const url = id ? '/politiques/' + id : '/politiques';

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
                            $('#politiqueModal').modal('hide');
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
                const text = isPublished ? 'Cette publication sera retirée du site.' : 'Cette publication sera visible sur le site.';

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
                        const url = isPublished ? '/politiques/' + id + '/unpublish' : '/politiques/' + id + '/publish';

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
            $(document).on('click', '.btn-delete-politique', function() {
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
                            url: '/politiques/' + id,
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
            // FILTRES
            // ============================================
            function applyFilters() {
                const type = $('.filter-type.active').data('value') || '';
                const status = $('.filter-status.active').data('value') || '';

                $.ajax({
                    url: '/politiques/filter',
                    method: 'GET',
                    data: { type: type, status: status },
                    success: function(response) {
                        if (response.success) {
                            $('#politique-table-body').html(response.html);
                            $('#politique-count').text(response.count);
                        }
                    }
                });
            }

            $('.filter-type').on('click', function(e) {
                e.preventDefault();
                $('.filter-type').removeClass('active');
                $(this).addClass('active');
                applyFilters();
            });

            $('.filter-status').on('click', function(e) {
                e.preventDefault();
                $('.filter-status').removeClass('active');
                $(this).addClass('active');
                applyFilters();
            });

            $('#btn-reset-filters').on('click', function() {
                $('.filter-type, .filter-status').removeClass('active');
                $('.filter-type[data-value=""]').addClass('active');
                $('.filter-status[data-value=""]').addClass('active');
                $('#search-politique').val('');
                applyFilters();
            });

            // ============================================
            // RECHERCHE
            // ============================================
            $('#btn-search').on('click', function() {
                const query = $('#search-politique').val();

                if (!query) {
                    applyFilters();
                    return;
                }

                $.ajax({
                    url: '/politiques/search',
                    method: 'GET',
                    data: { q: query },
                    success: function(response) {
                        if (response.success) {
                            $('#politique-table-body').html(response.html);
                            $('#politique-count').text(response.count);
                        }
                    }
                });
            });

            $('#search-politique').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btn-search').click();
                }
            });

            // ============================================
            // RESET MODAL
            // ============================================
            function resetModal() {
                $('#politique-form')[0].reset();
                $('#politique-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#politique_id').val('');
                $('#form-method').val('POST');
                $('#preview-file').html('');
                $('#file-info').hide();
            }

            // ============================================
            // APERÇU DU FICHIER
            // ============================================
            $('#fichier').on('change', function() {
                const file = this.files[0];
                if (file) {
                    $('#file-info').show();
                    $('#file-name').text(file.name);
                    $('#file-size').text((file.size / 1024).toFixed(1) + ' Ko');
                }
            });

        });
    </script>
@endpush
