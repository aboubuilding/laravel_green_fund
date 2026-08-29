@extends('layouts.app')

@section('title', 'Gestion des infos')

@section('page_title', 'Gestion des infos')
@section('page_icon', 'fa-info-circle')

@section('breadcrumb')
    <li class="active">Infos</li>
@endsection

@section('page_actions')
    <button class="btn-tgf-primary btn-sm" id="btn-new-info">
        <i class="fas fa-plus"></i> Nouvelle info
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
                        <button class="btn btn-outline-secondary btn-sm filter-status" data-value="active">
                            <i class="fas fa-check-circle text-success"></i> Actifs
                        </button>
                        <button class="btn btn-outline-secondary btn-sm filter-status" data-value="inactive">
                            <i class="fas fa-times-circle text-danger"></i> Inactifs
                        </button>
                    </div>
                    <button class="btn btn-outline-secondary btn-sm" id="btn-reset-filters">
                        <i class="fas fa-undo"></i> Réinitialiser
                    </button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" id="search-info" placeholder="Rechercher une info...">
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
                            <p class="stat-label">Total infos</p>
                        </div>
                        <div class="stat-icon bg-tgf-primary-light">
                            <i class="fas fa-info-circle text-tgf-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card-tgf" style="border-left-color: #2E8B57;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['active'] }}</p>
                            <p class="stat-label">Actifs</p>
                        </div>
                        <div class="stat-icon" style="background: rgba(46, 139, 87, 0.1);">
                            <i class="fas fa-check-circle text-tgf-success"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card-tgf" style="border-left-color: #DC3545;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['inactive'] }}</p>
                            <p class="stat-label">Inactifs</p>
                        </div>
                        <div class="stat-icon" style="background: rgba(220, 53, 69, 0.1);">
                            <i class="fas fa-times-circle text-tgf-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau --}}
        <div class="card-tgf">
            <div class="card-header">
                <i class="fas fa-list card-title-icon"></i>
                Liste des infos
                <span class="badge bg-primary ms-2" id="info-count">{{ $infos->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-tgf mb-0">
                        <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Contenu</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="info-table-body">
                        @include('infos._rows', ['infos' => $infos])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL INFO --}}
    @include('infos._modal')

@endsection

@push('js')
    <script>
        $(document).ready(function() {

            // ============================================
            // OUVERTURE MODAL - CRÉATION
            // ============================================
            $('#btn-new-info').on('click', function() {
                resetModal();
                $('#modal-title').text('Nouvelle info');
                $('#btn-submit-text').text('Créer');
                $('#form-method').val('POST');
                $('#info_id').val('');
                $('#info-form')[0].reset();
                $('#info-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#infoModal').modal('show');
            });

            // ============================================
            // OUVERTURE MODAL - ÉDITION
            // ============================================
            $(document).on('click', '.btn-edit-info', function() {
                const id = $(this).data('id');

                resetModal();
                $('#modal-title').text('Modifier l\'info');
                $('#btn-submit-text').text('Mettre à jour');
                $('#form-method').val('PUT');

                $.ajax({
                    url: '/infos/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        $('#info_id').val(data.id);
                        $('#titre').val(data.titre);
                        $('#contenu').val(data.contenu);
                        $('#date').val(data.date);
                        $('#info-form .is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').removeClass('show').empty();
                        $('#infoModal').modal('show');
                    },
                    error: function() {
                        toastr.error('Erreur lors du chargement des données.');
                    }
                });
            });

            // ============================================
            // SOUMISSION DU FORMULAIRE (AJAX)
            // ============================================
            $('#info-form').on('submit', function(e) {
                e.preventDefault();

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();

                const form = $(this);
                const formData = form.serialize();
                const id = $('#info_id').val();
                const url = id ? '/infos/' + id : '/infos';

                const btn = $('#btn-submit');
                const originalText = btn.html();
                btn.html('<i class="fas fa-spinner fa-spin"></i> Chargement...').prop('disabled', true);

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        btn.html(originalText).prop('disabled', false);

                        if (response.success) {
                            toastr.success(response.message);
                            $('#infoModal').modal('hide');
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
            // CHANGER LE STATUT
            // ============================================
            $(document).on('click', '.btn-toggle-status', function() {
                const id = $(this).data('id');
                const isActive = $(this).data('active') === 1;
                const btn = $(this);

                const title = isActive ? 'Désactiver' : 'Activer';
                const text = isActive ? 'Cette info sera masquée sur le site.' : 'Cette info sera visible sur le site.';

                Swal.fire({
                    title: 'Confirmer',
                    html: `<strong>${title}</strong><br><small class="text-muted">${text}</small>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: isActive ? '#DC3545' : '#2E8B57',
                    cancelButtonColor: '#6B8A7E',
                    confirmButtonText: isActive ? 'Oui, désactiver' : 'Oui, activer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        btn.prop('disabled', true);
                        btn.html('<i class="fas fa-spinner fa-spin"></i>');

                        $.ajax({
                            url: '/infos/' + id + '/toggle-status',
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
                                toastr.error('Erreur lors de la mise à jour du statut.');
                                btn.prop('disabled', false);
                                btn.html(isActive ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>');
                            }
                        });
                    }
                });
            });

            // ============================================
            // SUPPRESSION (SweetAlert + AJAX)
            // ============================================
            $(document).on('click', '.btn-delete-info', function() {
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
                            url: '/infos/' + id,
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
                const statut = $('.filter-status.active').data('value') || '';

                $.ajax({
                    url: '/infos/filter',
                    method: 'GET',
                    data: { statut: statut },
                    success: function(response) {
                        if (response.success) {
                            $('#info-table-body').html(response.html);
                            $('#info-count').text(response.count);
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
                $('#search-info').val('');
                applyFilters();
            });

            // ============================================
            // RECHERCHE
            // ============================================
            $('#btn-search').on('click', function() {
                const query = $('#search-info').val();

                if (!query) {
                    applyFilters();
                    return;
                }

                $.ajax({
                    url: '/infos/search',
                    method: 'GET',
                    data: { q: query },
                    success: function(response) {
                        if (response.success) {
                            $('#info-table-body').html(response.html);
                            $('#info-count').text(response.count);
                        }
                    }
                });
            });

            $('#search-info').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btn-search').click();
                }
            });

            // ============================================
            // RESET MODAL
            // ============================================
            function resetModal() {
                $('#info-form')[0].reset();
                $('#info-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#info_id').val('');
                $('#form-method').val('POST');
            }

        });
    </script>
@endpush
