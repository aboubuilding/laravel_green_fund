@extends('layouts.app')

@section('title', 'Gestion des événements')

@section('page_title', 'Gestion des événements')
@section('page_icon', 'fa-calendar')

@section('breadcrumb')
    <li class="active">Événements</li>
@endsection

@section('page_actions')
    <button class="btn-tgf-primary btn-sm" id="btn-new-evenement">
        <i class="fas fa-plus"></i> Nouvel événement
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
                            <i class="fas fa-filter"></i> Statut
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item filter-status active" href="#" data-value="">Tous</a></li>
                            <li><a class="dropdown-item filter-status" href="#" data-value="upcoming">À venir</a></li>
                            <li><a class="dropdown-item filter-status" href="#" data-value="past">Passés</a></li>
                        </ul>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-tag"></i> Type
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item filter-type active" href="#" data-value="">Tous</a></li>
                            @foreach($types as $value => $label)
                                <li><a class="dropdown-item filter-type" href="#" data-value="{{ $value }}">{{ $label }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <button class="btn btn-outline-secondary btn-sm" id="btn-reset-filters">
                        <i class="fas fa-undo"></i> Réinitialiser
                    </button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" id="search-evenement" placeholder="Rechercher un événement...">
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
                            <p class="stat-label">Total événements</p>
                        </div>
                        <div class="stat-icon bg-tgf-primary-light">
                            <i class="fas fa-calendar text-tgf-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #2E8B57;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['upcoming'] }}</p>
                            <p class="stat-label">À venir</p>
                        </div>
                        <div class="stat-icon" style="background: rgba(46, 139, 87, 0.1);">
                            <i class="fas fa-clock text-tgf-success"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #DC3545;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['past'] }}</p>
                            <p class="stat-label">Passés</p>
                        </div>
                        <div class="stat-icon" style="background: rgba(220, 53, 69, 0.1);">
                            <i class="fas fa-history text-tgf-danger"></i>
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
                            <i class="fas fa-calendar-plus" style="color: #6B46C1;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau --}}
        <div class="card-tgf">
            <div class="card-header">
                <i class="fas fa-list card-title-icon"></i>
                Liste des événements
                <span class="badge bg-primary ms-2" id="evenement-count">{{ $evenements->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-tgf mb-0">
                        <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Date</th>
                            <th>Lieu</th>
                            <th>Type</th>
                            <th>Statut</th>
                            <th>Publication</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="evenement-table-body">
                        @include('evenements._rows', ['evenements' => $evenements])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL ÉVÉNEMENT --}}
    @include('evenements._modal')

@endsection

@push('js')
    <script>
        $(document).ready(function() {

            // ============================================
            // OUVERTURE MODAL - CRÉATION
            // ============================================
            $('#btn-new-evenement').on('click', function() {
                resetModal();
                $('#modal-title').text('Nouvel événement');
                $('#btn-submit-text').text('Créer');
                $('#form-method').val('POST');
                $('#evenement_id').val('');
                $('#evenement-form')[0].reset();
                $('#evenement-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#image-required').show();
                $('#image').prop('required', true);
                $('#image-preview-container').hide();
                $('#evenementModal').modal('show');
            });

            // ============================================
            // OUVERTURE MODAL - ÉDITION
            // ============================================
            $(document).on('click', '.btn-edit-evenement', function() {
                const id = $(this).data('id');

                resetModal();
                $('#modal-title').text('Modifier l\'événement');
                $('#btn-submit-text').text('Mettre à jour');
                $('#form-method').val('PUT');

                $.ajax({
                    url: '/evenements/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        $('#evenement_id').val(data.id);
                        $('#titre').val(data.titre);
                        $('#description').val(data.description);
                        $('#date_evenement').val(data.date_evenement);
                        $('#lieu').val(data.lieu);
                        $('#type_evenement').val(data.type_evenement);
                        $('#image-required').hide();
                        $('#image').prop('required', false);

                        if (data.image_url && data.image_url !== '/images/event-placeholder.jpg') {
                            $('#image-preview-container').show();
                            $('#image-preview').attr('src', data.image_url);
                        } else {
                            $('#image-preview-container').hide();
                        }

                        $('#evenement-form .is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').removeClass('show').empty();
                        $('#evenementModal').modal('show');
                    },
                    error: function() {
                        toastr.error('Erreur lors du chargement des données.');
                    }
                });
            });

            // ============================================
            // SOUMISSION DU FORMULAIRE (AJAX)
            // ============================================
            $('#evenement-form').on('submit', function(e) {
                e.preventDefault();

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();

                const form = $(this);
                const formData = new FormData(this);
                const id = $('#evenement_id').val();
                const url = id ? '/evenements/' + id : '/evenements';

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
                            $('#evenementModal').modal('hide');
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
                const text = isPublished ? 'Cet événement sera retiré du site.' : 'Cet événement sera visible sur le site.';

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
                        const url = isPublished ? '/evenements/' + id + '/unpublish' : '/evenements/' + id + '/publish';

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
            $(document).on('click', '.btn-delete-evenement', function() {
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
                            url: '/evenements/' + id,
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
            // APERÇU DE L'IMAGE
            // ============================================
            $('#image').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image-preview-container').show();
                        $('#image-preview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // ============================================
            // FILTRES
            // ============================================
            function applyFilters() {
                const statut = $('.filter-status.active').data('value') || '';
                const type = $('.filter-type.active').data('value') || '';

                $.ajax({
                    url: '/evenements/filter',
                    method: 'GET',
                    data: { statut: statut, type: type },
                    success: function(response) {
                        if (response.success) {
                            $('#evenement-table-body').html(response.html);
                            $('#evenement-count').text(response.count);
                        }
                    }
                });
            }

            $('.filter-status').on('click', function(e) {
                e.preventDefault();
                $('.filter-status').removeClass('active');
                $(this).addClass('active');
                applyFilters();
            });

            $('.filter-type').on('click', function(e) {
                e.preventDefault();
                $('.filter-type').removeClass('active');
                $(this).addClass('active');
                applyFilters();
            });

            $('#btn-reset-filters').on('click', function() {
                $('.filter-status, .filter-type').removeClass('active');
                $('.filter-status[data-value=""]').addClass('active');
                $('.filter-type[data-value=""]').addClass('active');
                $('#search-evenement').val('');
                applyFilters();
            });

            // ============================================
            // RECHERCHE
            // ============================================
            $('#btn-search').on('click', function() {
                const query = $('#search-evenement').val();

                if (!query) {
                    applyFilters();
                    return;
                }

                $.ajax({
                    url: '/evenements/search',
                    method: 'GET',
                    data: { q: query },
                    success: function(response) {
                        if (response.success) {
                            $('#evenement-table-body').html(response.html);
                            $('#evenement-count').text(response.count);
                        }
                    }
                });
            });

            $('#search-evenement').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btn-search').click();
                }
            });

            // ============================================
            // RESET MODAL
            // ============================================
            function resetModal() {
                $('#evenement-form')[0].reset();
                $('#evenement-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#evenement_id').val('');
                $('#form-method').val('POST');
                $('#image-preview-container').hide();
                $('#image-preview').attr('src', '');
            }

        });
    </script>
@endpush
