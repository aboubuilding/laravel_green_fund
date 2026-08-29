@extends('layouts.app')

@section('title', 'Gestion des griefs')

@section('page_title', 'Gestion des griefs')
@section('page_icon', 'fa-exclamation-triangle')

@section('breadcrumb')
    <li class="active">Griefs</li>
@endsection

@section('page_actions')
    <button class="btn-tgf-primary btn-sm" id="btn-new-grief">
        <i class="fas fa-plus"></i> Nouveau grief
    </button>
    <a href="{{ route('griefs.export') }}" class="btn-tgf-outline-primary btn-sm">
        <i class="fas fa-file-export"></i> Exporter (CSV)
    </a>
@endsection

@section('contenu')

    <div class="container-fluid px-0">

        {{-- Filtres --}}
        <div class="row g-3 mb-4">
            <div class="col-md-8">
                <div class="d-flex gap-2 flex-wrap">
                    <div class="btn-group">
                        <button class="btn btn-outline-secondary btn-sm filter-status active" data-value="">Tous</button>
                        @foreach($statuts as $value => $label)
                            <button class="btn btn-outline-secondary btn-sm filter-status" data-value="{{ $value }}">
                                <i class="fas {{ StatutGrief::getIcon($value) }}"></i>
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                    <button class="btn btn-outline-secondary btn-sm" id="btn-reset-filters">
                        <i class="fas fa-undo"></i> Réinitialiser
                    </button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" id="search-grief" placeholder="Rechercher un grief...">
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
                            <p class="stat-label">Total griefs</p>
                        </div>
                        <div class="stat-icon bg-tgf-primary-light">
                            <i class="fas fa-exclamation-triangle text-tgf-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #DC3545;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['nouveaux'] }}</p>
                            <p class="stat-label">Nouveaux</p>
                        </div>
                        <div class="stat-icon" style="background: rgba(220, 53, 69, 0.1);">
                            <i class="fas fa-exclamation-circle text-tgf-danger"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #F5A623;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['en_cours'] }}</p>
                            <p class="stat-label">En cours</p>
                        </div>
                        <div class="stat-icon bg-tgf-accent-light">
                            <i class="fas fa-spinner text-tgf-accent"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #2E8B57;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['resolus'] }}</p>
                            <p class="stat-label">Résolus</p>
                        </div>
                        <div class="stat-icon" style="background: rgba(46, 139, 87, 0.1);">
                            <i class="fas fa-check-circle text-tgf-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau --}}
        <div class="card-tgf">
            <div class="card-header">
                <i class="fas fa-list card-title-icon"></i>
                Liste des griefs
                <span class="badge bg-primary ms-2" id="grief-count">{{ $griefs->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-tgf mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Plaignant</th>
                            <th>Contact</th>
                            <th>Projet</th>
                            <th>Description</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="grief-table-body">
                        @include('griefs._rows', ['griefs' => $griefs])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL GRIEF --}}
    @include('griefs._modal')

    {{-- MODAL DÉTAIL GRIEF --}}
    @include('griefs._detail')

    {{-- MODAL RÉPONSE --}}
    @include('griefs._reponse')

@endsection

@push('js')
    <script>
        $(document).ready(function() {

            // ============================================
            // OUVERTURE MODAL - CRÉATION
            // ============================================
            $('#btn-new-grief').on('click', function() {
                resetModal();
                $('#modal-title').text('Nouveau grief');
                $('#btn-submit-text').text('Créer');
                $('#form-method').val('POST');
                $('#grief_id').val('');
                $('#grief-form')[0].reset();
                $('#grief-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#griefModal').modal('show');
            });

            // ============================================
            // OUVERTURE MODAL - DÉTAIL
            // ============================================
            $(document).on('click', '.btn-show-grief', function() {
                const id = $(this).data('id');

                $.ajax({
                    url: '/griefs/' + id,
                    method: 'GET',
                    success: function(data) {
                        if (data.success) {
                            const grief = data.grief;
                            $('#detail-grief-nom').text(grief.nom);
                            $('#detail-grief-email').text(grief.email || '-');
                            $('#detail-grief-telephone').text(grief.telephone || '-');
                            $('#detail-grief-projet').text(grief.nom_projet);
                            $('#detail-grief-description').text(grief.description);
                            $('#detail-grief-statut').html(`
                        <span class="badge badge-tgf-${grief.statut_badge}">
                            <i class="fas ${grief.statut_icon}"></i>
                            ${grief.statut_label}
                        </span>
                    `);
                            $('#detail-grief-date').text(grief.date_formatee);
                            $('#detail-grief-reponse').text(grief.reponse || 'Aucune réponse pour le moment.');
                            $('#detail-grief-id').val(grief.id);
                            $('#detailGriefModal').modal('show');
                        }
                    }
                });
            });

            // ============================================
            // OUVERTURE MODAL - ÉDITION
            // ============================================
            $(document).on('click', '.btn-edit-grief', function() {
                const id = $(this).data('id');

                resetModal();
                $('#modal-title').text('Modifier le grief');
                $('#btn-submit-text').text('Mettre à jour');
                $('#form-method').val('PUT');

                $.ajax({
                    url: '/griefs/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        if (data.success) {
                            $('#grief_id').val(data.id);
                            $('#nom').val(data.nom);
                            $('#email').val(data.email);
                            $('#telephone').val(data.telephone);
                            $('#projet_concerne_id').val(data.projet_concerne_id);
                            $('#description').val(data.description);
                            $('#statut').val(data.statut);
                            $('#reponse').val(data.reponse);
                            $('#grief-form .is-invalid').removeClass('is-invalid');
                            $('.invalid-feedback').removeClass('show').empty();
                            $('#griefModal').modal('show');
                        }
                    },
                    error: function() {
                        toastr.error('Erreur lors du chargement des données.');
                    }
                });
            });

            // ============================================
            // OUVERTURE MODAL - RÉPONSE
            // ============================================
            $(document).on('click', '.btn-repondre-grief', function() {
                const id = $(this).data('id');
                $('#reponse-grief-id').val(id);
                $('#reponse-text').val('');
                $('#reponseModal').modal('show');
            });

            // ============================================
            // SOUMISSION FORMULAIRE GRIEF
            // ============================================
            $('#grief-form').on('submit', function(e) {
                e.preventDefault();

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();

                const form = $(this);
                const formData = form.serialize();
                const id = $('#grief_id').val();
                const url = id ? '/griefs/' + id : '/griefs';

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
                            $('#griefModal').modal('hide');
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
            // SOUMISSION RÉPONSE
            // ============================================
            $('#reponse-form').on('submit', function(e) {
                e.preventDefault();

                const id = $('#reponse-grief-id').val();
                const reponse = $('#reponse-text').val();

                if (!reponse) {
                    toastr.warning('Veuillez saisir une réponse.');
                    return;
                }

                const btn = $('#btn-repondre');
                const originalText = btn.html();
                btn.html('<i class="fas fa-spinner fa-spin"></i> Envoi...').prop('disabled', true);

                $.ajax({
                    url: '/griefs/' + id + '/repondre',
                    method: 'POST',
                    data: { reponse: reponse },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        btn.html(originalText).prop('disabled', false);

                        if (response.success) {
                            toastr.success(response.message);
                            $('#reponseModal').modal('hide');
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        }
                    },
                    error: function() {
                        btn.html(originalText).prop('disabled', false);
                        toastr.error('Erreur lors de l\'envoi de la réponse.');
                    }
                });
            });

            // ============================================
            // CHANGER LE STATUT
            // ============================================
            $(document).on('click', '.btn-changer-statut', function() {
                const id = $(this).data('id');
                const statut = $(this).data('statut');
                const label = $(this).data('label');

                Swal.fire({
                    title: 'Confirmer',
                    html: `Voulez-vous passer ce grief en statut <strong>${label}</strong> ?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#F5A623',
                    cancelButtonColor: '#6B8A7E',
                    confirmButtonText: 'Oui, changer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/griefs/' + id + '/changer-statut',
                            method: 'POST',
                            data: { statut: statut },
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
                                toastr.error('Erreur lors du changement de statut.');
                            }
                        });
                    }
                });
            });

            // ============================================
            // CLÔTURER UN GRIEF
            // ============================================
            $(document).on('click', '.btn-cloturer-grief', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Clôturer le grief',
                    text: 'Voulez-vous vraiment clôturer ce grief ?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2E8B57',
                    cancelButtonColor: '#6B8A7E',
                    confirmButtonText: 'Oui, clôturer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/griefs/' + id + '/cloturer',
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
                                toastr.error('Erreur lors de la clôture.');
                            }
                        });
                    }
                });
            });

            // ============================================
            // SUPPRESSION
            // ============================================
            $(document).on('click', '.btn-delete-grief', function() {
                const id = $(this).data('id');
                const nom = $(this).data('nom');

                Swal.fire({
                    title: 'Confirmer la suppression',
                    html: `Voulez-vous vraiment supprimer le grief de <strong>${nom}</strong> ?<br><small class="text-muted">Cette action est irréversible.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DC3545',
                    cancelButtonColor: '#6B8A7E',
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/griefs/' + id,
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
            // FILTRES
            // ============================================
            function applyFilters() {
                const statut = $('.filter-status.active').data('value') || '';

                $.ajax({
                    url: '/griefs/filter',
                    method: 'GET',
                    data: { statut: statut },
                    success: function(response) {
                        if (response.success) {
                            $('#grief-table-body').html(response.html);
                            $('#grief-count').text(response.count);
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
                $('#search-grief').val('');
                applyFilters();
            });

            // ============================================
            // RECHERCHE
            // ============================================
            $('#btn-search').on('click', function() {
                const query = $('#search-grief').val();

                if (!query) {
                    applyFilters();
                    return;
                }

                $.ajax({
                    url: '/griefs/search',
                    method: 'GET',
                    data: { q: query },
                    success: function(response) {
                        if (response.success) {
                            $('#grief-table-body').html(response.html);
                            $('#grief-count').text(response.count);
                        }
                    }
                });
            });

            $('#search-grief').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btn-search').click();
                }
            });

            // ============================================
            // RESET MODAL
            // ============================================
            function resetModal() {
                $('#grief-form')[0].reset();
                $('#grief-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#grief_id').val('');
                $('#form-method').val('POST');
            }

        });
    </script>
@endpush
