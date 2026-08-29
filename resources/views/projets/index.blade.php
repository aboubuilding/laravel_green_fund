@extends('layouts.app')

@section('title', 'Gestion des projets')

@section('page_title', 'Gestion des projets')
@section('page_icon', 'fa-diagram-project')

@section('breadcrumb')
    <li class="active">Projets</li>
@endsection

@section('page_actions')
    <button class="btn-tgf-primary btn-sm" id="btn-new-projet">
        <i class="fas fa-plus"></i> Nouveau projet
    </button>
@endsection

@section('contenu')

    <div class="container-fluid px-0">

        {{-- Filtres --}}
        <div class="row g-3 mb-4">
            <div class="col-md-9">
                <div class="d-flex gap-2 flex-wrap">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-filter"></i> Statut
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item filter-statut active" href="#" data-value="">Tous</a></li>
                            @foreach($statuts as $value => $label)
                                <li><a class="dropdown-item filter-statut" href="#" data-value="{{ $value }}">{{ $label }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-map-marker-alt"></i> Région
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item filter-region active" href="#" data-value="">Toutes</a></li>
                            @foreach($regions as $region)
                                <li><a class="dropdown-item filter-region" href="#" data-value="{{ $region->id }}">{{ $region->nom }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-tag"></i> Type
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item filter-type active" href="#" data-value="">Tous</a></li>
                            @foreach($types as $type)
                                <li><a class="dropdown-item filter-type" href="#" data-value="{{ $type->id }}">{{ $type->libelle }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <button class="btn btn-outline-secondary btn-sm" id="btn-reset-filters">
                        <i class="fas fa-undo"></i> Réinitialiser
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" id="search-projet" placeholder="Rechercher un projet...">
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
                            <p class="stat-label">Total projets</p>
                        </div>
                        <div class="stat-icon bg-tgf-primary-light">
                            <i class="fas fa-diagram-project text-tgf-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #007bff;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['en_cours'] }}</p>
                            <p class="stat-label">En cours</p>
                        </div>
                        <div class="stat-icon" style="background: rgba(0, 123, 255, 0.1);">
                            <i class="fas fa-spinner" style="color: #007bff;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #28a745;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['termines'] }}</p>
                            <p class="stat-label">Terminés</p>
                        </div>
                        <div class="stat-icon" style="background: rgba(40, 167, 69, 0.1);">
                            <i class="fas fa-check-circle" style="color: #28a745;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #ffc107;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['a_venir'] }}</p>
                            <p class="stat-label">À venir</p>
                        </div>
                        <div class="stat-icon" style="background: rgba(255, 193, 7, 0.1);">
                            <i class="fas fa-clock" style="color: #ffc107;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau --}}
        <div class="card-tgf">
            <div class="card-header">
                <i class="fas fa-list card-title-icon"></i>
                Liste des projets
                <span class="badge bg-primary ms-2" id="projet-count">{{ $projets->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-tgf mb-0">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Type</th>
                            <th>Région</th>
                            <th>Statut</th>
                            <th>Budget</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="projet-table-body">
                        @include('projets._rows', ['projets' => $projets])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL PROJET --}}
    @include('projets._modal')

@endsection

@push('js')
    <script>
        $(document).ready(function() {

            // ============================================
            // OUVERTURE MODAL - CRÉATION
            // ============================================
            $('#btn-new-projet').on('click', function() {
                resetModal();
                $('#modal-title').text('Nouveau projet');
                $('#btn-submit-text').text('Créer');
                $('#form-method').val('POST');
                $('#projet_id').val('');
                $('#projet-form')[0].reset();
                $('#projet-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#image-required').show();
                $('#image').prop('required', true);
                $('#image-preview-container').hide();
                $('#projetModal').modal('show');
            });

            // ============================================
            // OUVERTURE MODAL - ÉDITION
            // ============================================
            $(document).on('click', '.btn-edit-projet', function() {
                const id = $(this).data('id');

                resetModal();
                $('#modal-title').text('Modifier le projet');
                $('#btn-submit-text').text('Mettre à jour');
                $('#form-method').val('PUT');

                $.ajax({
                    url: '/projets/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        if (data.success) {
                            $('#projet_id').val(data.id);
                            $('#titre').val(data.titre);
                            $('#slug').val(data.slug);
                            $('#description').val(data.description);
                            $('#region_id').val(data.region_id);
                            $('#prefecture_id').val(data.prefecture_id);
                            $('#commune_id').val(data.commune_id);
                            $('#statut_projet').val(data.statut_projet);
                            $('#type_projet_id').val(data.type_projet_id);
                            $('#budget').val(data.budget);
                            $('#date_debut').val(data.date_debut);
                            $('#date_fin').val(data.date_fin);

                            if (data.image) {
                                $('#image-preview-container').show();
                                $('#image-preview').attr('src', '/storage/' + data.image);
                            } else {
                                $('#image-preview-container').hide();
                            }

                            $('#image-required').hide();
                            $('#image').prop('required', false);
                            $('#projet-form .is-invalid').removeClass('is-invalid');
                            $('.invalid-feedback').removeClass('show').empty();
                            $('#projetModal').modal('show');
                        }
                    },
                    error: function() {
                        toastr.error('Erreur lors du chargement des données.');
                    }
                });
            });

            // ============================================
            // SOUMISSION FORMULAIRE PROJET
            // ============================================
            $('#projet-form').on('submit', function(e) {
                e.preventDefault();

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();

                const form = $(this);
                const formData = new FormData(this);
                const id = $('#projet_id').val();
                const url = id ? '/projets/' + id : '/projets';

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
                            $('#projetModal').modal('hide');
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
            // SUPPRESSION
            // ============================================
            $(document).on('click', '.btn-delete-projet', function() {
                const id = $(this).data('id');
                const titre = $(this).data('titre');

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
                        $.ajax({
                            url: '/projets/' + id,
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
                const statut = $('.filter-statut.active').data('value') || '';
                const region = $('.filter-region.active').data('value') || '';
                const type = $('.filter-type.active').data('value') || '';

                $.ajax({
                    url: '/projets/filter',
                    method: 'GET',
                    data: { statut: statut, region: region, type: type },
                    success: function(response) {
                        if (response.success) {
                            $('#projet-table-body').html(response.html);
                            $('#projet-count').text(response.count);
                        }
                    }
                });
            }

            $('.filter-statut').on('click', function(e) {
                e.preventDefault();
                $('.filter-statut').removeClass('active');
                $(this).addClass('active');
                applyFilters();
            });

            $('.filter-region').on('click', function(e) {
                e.preventDefault();
                $('.filter-region').removeClass('active');
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
                $('.filter-statut, .filter-region, .filter-type').removeClass('active');
                $('.filter-statut[data-value=""]').addClass('active');
                $('.filter-region[data-value=""]').addClass('active');
                $('.filter-type[data-value=""]').addClass('active');
                $('#search-projet').val('');
                applyFilters();
            });

            // ============================================
            // RECHERCHE
            // ============================================
            $('#btn-search').on('click', function() {
                const query = $('#search-projet').val();

                if (!query) {
                    applyFilters();
                    return;
                }

                $.ajax({
                    url: '/projets/search',
                    method: 'GET',
                    data: { q: query },
                    success: function(response) {
                        if (response.success) {
                            $('#projet-table-body').html(response.html);
                            $('#projet-count').text(response.count);
                        }
                    }
                });
            });

            $('#search-projet').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btn-search').click();
                }
            });

            // ============================================
            // RESET MODAL
            // ============================================
            function resetModal() {
                $('#projet-form')[0].reset();
                $('#projet-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#projet_id').val('');
                $('#form-method').val('POST');
                $('#image-preview-container').hide();
                $('#image-preview').attr('src', '');
            }

        });
    </script>
@endpush
