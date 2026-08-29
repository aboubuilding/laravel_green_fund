@extends('layouts.app')

@section('title', 'Gestion des actualités')

@section('page_title', 'Gestion des actualités')
@section('page_icon', 'fa-newspaper')

@section('breadcrumb')
    <li class="active">Actualités</li>
@endsection

@section('page_actions')
    <button class="btn-tgf-primary btn-sm" id="btn-new-actualite">
        <i class="fas fa-plus"></i> Nouvelle actualité
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
                    <input type="text" class="form-control" id="search-actualite" placeholder="Rechercher une actualité...">
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
                            <p class="stat-label">Total actualités</p>
                        </div>
                        <div class="stat-icon bg-tgf-primary-light">
                            <i class="fas fa-newspaper text-tgf-primary"></i>
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
                            <p class="stat-number">{{ $stats['scheduled'] }}</p>
                            <p class="stat-label">Programmés</p>
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
                Liste des actualités
                <span class="badge bg-primary ms-2" id="actualite-count">{{ $actualites->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-tgf mb-0">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Date publication</th>
                            <th>Statut</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="actualite-table-body">
                        @include('actualites._rows', ['actualites' => $actualites])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL ACTUALITÉ --}}
    @include('actualites._modal')

@endsection

@push('css')
    <style>
        .image-preview {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        .image-preview-placeholder {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            background: #f0f5f2;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8AA89A;
            font-size: 1.5rem;
        }
        .quill-editor {
            min-height: 200px;
            background: #fff;
            border-radius: 8px;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {

            // ============================================
            // OUVERTURE MODAL - CRÉATION
            // ============================================
            $('#btn-new-actualite').on('click', function() {
                resetModal();
                $('#modal-title').text('Nouvelle actualité');
                $('#btn-submit-text').text('Créer');
                $('#form-method').val('POST');
                $('#actualite_id').val('');
                $('#actualite-form')[0].reset();
                $('#actualite-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#image-preview-container').hide();
                $('#image-required').show();
                $('#image').prop('required', true);
                $('#actualiteModal').modal('show');
            });

            // ============================================
            // OUVERTURE MODAL - ÉDITION
            // ============================================
            $(document).on('click', '.btn-edit-actualite', function() {
                const id = $(this).data('id');

                resetModal();
                $('#modal-title').text('Modifier l\'actualité');
                $('#btn-submit-text').text('Mettre à jour');
                $('#form-method').val('PUT');

                $.ajax({
                    url: '/actualites/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        $('#actualite_id').val(data.id);
                        $('#titre').val(data.titre);
                        $('#slug').val(data.slug);
                        $('#contenu').val(data.contenu);
                        $('#extrait').val(data.extrait);
                        $('#statut_actualite').val(data.statut_actualite);
                        $('#date_publication').val(data.date_publication);
                        $('#image-required').hide();
                        $('#image').prop('required', false);

                        if (data.image_url && data.image_url !== '/images/no-image.png') {
                            $('#image-preview-container').show();
                            $('#image-preview').attr('src', data.image_url);
                        } else {
                            $('#image-preview-container').hide();
                        }

                        $('#actualite-form .is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').removeClass('show').empty();
                        $('#actualiteModal').modal('show');
                    },
                    error: function() {
                        toastr.error('Erreur lors du chargement des données.');
                    }
                });
            });

            // ============================================
            // SOUMISSION DU FORMULAIRE (AJAX)
            // ============================================
            $('#actualite-form').on('submit', function(e) {
                e.preventDefault();

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();

                const form = $(this);
                const formData = new FormData(this);
                const id = $('#actualite_id').val();
                const url = id ? '/actualites/' + id : '/actualites';

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
                            $('#actualiteModal').modal('hide');
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
                const text = isPublished ? 'Cette actualité sera retirée du site.' : 'Cette actualité sera visible sur le site.';

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
                        const url = isPublished ? '/actualites/' + id + '/unpublish' : '/actualites/' + id + '/publish';

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
            $(document).on('click', '.btn-delete-actualite', function() {
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
                            url: '/actualites/' + id,
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

                $.ajax({
                    url: '/actualites/filter',
                    method: 'GET',
                    data: { statut: statut },
                    success: function(response) {
                        if (response.success) {
                            $('#actualite-table-body').html(response.html);
                            $('#actualite-count').text(response.count);
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
                $('#search-actualite').val('');
                applyFilters();
            });

            // ============================================
            // RECHERCHE
            // ============================================
            $('#btn-search').on('click', function() {
                const query = $('#search-actualite').val();

                if (!query) {
                    applyFilters();
                    return;
                }

                $.ajax({
                    url: '/actualites/search',
                    method: 'GET',
                    data: { q: query },
                    success: function(response) {
                        if (response.success) {
                            $('#actualite-table-body').html(response.html);
                            $('#actualite-count').text(response.count);
                        }
                    }
                });
            });

            $('#search-actualite').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btn-search').click();
                }
            });

            // ============================================
            // RESET MODAL
            // ============================================
            function resetModal() {
                $('#actualite-form')[0].reset();
                $('#actualite-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#actualite_id').val('');
                $('#form-method').val('POST');
                $('#image-preview-container').hide();
                $('#image-preview').attr('src', '');
            }

        });
    </script>
@endpush
