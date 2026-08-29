@extends('layouts.app')

@section('title', 'Gestion des plaintes')

@section('page_title', 'Gestion des plaintes')
@section('page_icon', 'fa-file-signature')

@section('breadcrumb')
    <li class="active">Plaintes</li>
@endsection

@section('page_actions')
    <button class="btn-tgf-primary btn-sm" id="btn-new-plainte">
        <i class="fas fa-plus"></i> Nouvelle plainte
    </button>
    <a href="{{ route('plaintes.export') }}" class="btn-tgf-outline-primary btn-sm">
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
                                <i class="fas {{ StatutPlainte::getIcon($value) }}"></i>
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
                    <input type="text" class="form-control" id="search-plainte" placeholder="Rechercher une plainte...">
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
                            <p class="stat-label">Total plaintes</p>
                        </div>
                        <div class="stat-icon bg-tgf-primary-light">
                            <i class="fas fa-file-signature text-tgf-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #DC3545;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['nouvelles'] }}</p>
                            <p class="stat-label">Nouvelles</p>
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
                            <p class="stat-number">{{ $stats['resolues'] }}</p>
                            <p class="stat-label">Résolues</p>
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
                Liste des plaintes
                <span class="badge bg-primary ms-2" id="plainte-count">{{ $plaintes->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-tgf mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Plaignant</th>
                            <th>Contact</th>
                            <th>Objet</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="plainte-table-body">
                        @include('plaintes._rows', ['plaintes' => $plaintes])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL PLAINTE --}}
    @include('plaintes._modal')

    {{-- MODAL DÉTAIL PLAINTE --}}
    @include('plaintes._detail')

    {{-- MODAL RÉPONSE --}}
    @include('plaintes._reponse')

@endsection

@push('js')
    <script>
        $(document).ready(function() {

            // ============================================
            // OUVERTURE MODAL - CRÉATION
            // ============================================
            $('#btn-new-plainte').on('click', function() {
                resetModal();
                $('#modal-title').text('Nouvelle plainte');
                $('#btn-submit-text').text('Créer');
                $('#form-method').val('POST');
                $('#plainte_id').val('');
                $('#plainte-form')[0].reset();
                $('#plainte-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#plainteModal').modal('show');
            });

            // ============================================
            // OUVERTURE MODAL - DÉTAIL
            // ============================================
            $(document).on('click', '.btn-show-plainte', function() {
                const id = $(this).data('id');

                $.ajax({
                    url: '/plaintes/' + id,
                    method: 'GET',
                    success: function(data) {
                        if (data.success) {
                            const plainte = data.plainte;
                            $('#detail-plainte-nom').text(plainte.nom);
                            $('#detail-plainte-email').text(plainte.email || '-');
                            $('#detail-plainte-telephone').text(plainte.telephone || '-');
                            $('#detail-plainte-objet').text(plainte.objet);
                            $('#detail-plainte-description').text(plainte.description);
                            $('#detail-plainte-statut').html(`
                        <span class="badge badge-tgf-${plainte.statut_badge}">
                            <i class="fas ${plainte.statut_icon}"></i>
                            ${plainte.statut_label}
                        </span>
                    `);
                            $('#detail-plainte-date').text(plainte.date_formatee);
                            $('#detail-plainte-reponse').text(plainte.reponse || 'Aucune réponse pour le moment.');
                            $('#detail-plainte-id').val(plainte.id);
                            $('#detailPlainteModal').modal('show');
                        }
                    }
                });
            });

            // ============================================
            // OUVERTURE MODAL - ÉDITION
            // ============================================
            $(document).on('click', '.btn-edit-plainte', function() {
                const id = $(this).data('id');

                resetModal();
                $('#modal-title').text('Modifier la plainte');
                $('#btn-submit-text').text('Mettre à jour');
                $('#form-method').val('PUT');

                $.ajax({
                    url: '/plaintes/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        if (data.success) {
                            $('#plainte_id').val(data.id);
                            $('#nom').val(data.nom);
                            $('#email').val(data.email);
                            $('#telephone').val(data.telephone);
                            $('#objet').val(data.objet);
                            $('#description').val(data.description);
                            $('#statut').val(data.statut);
                            $('#reponse').val(data.reponse);
                            $('#plainte-form .is-invalid').removeClass('is-invalid');
                            $('.invalid-feedback').removeClass('show').empty();
                            $('#plainteModal').modal('show');
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
            $(document).on('click', '.btn-repondre-plainte', function() {
                const id = $(this).data('id');
                $('#reponse-plainte-id').val(id);
                $('#reponse-text').val('');
                $('#reponseModal').modal('show');
            });

            // ============================================
            // SOUMISSION FORMULAIRE PLAINTE
            // ============================================
            $('#plainte-form').on('submit', function(e) {
                e.preventDefault();

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();

                const form = $(this);
                const formData = form.serialize();
                const id = $('#plainte_id').val();
                const url = id ? '/plaintes/' + id : '/plaintes';

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
                            $('#plainteModal').modal('hide');
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

                const id = $('#reponse-plainte-id').val();
                const reponse = $('#reponse-text').val();

                if (!reponse) {
                    toastr.warning('Veuillez saisir une réponse.');
                    return;
                }

                const btn = $('#btn-repondre');
                const originalText = btn.html();
                btn.html('<i class="fas fa-spinner fa-spin"></i> Envoi...').prop('disabled', true);

                $.ajax({
                    url: '/plaintes/' + id + '/repondre',
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
                    html: `Voulez-vous passer cette plainte en statut <strong>${label}</strong> ?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#F5A623',
                    cancelButtonColor: '#6B8A7E',
                    confirmButtonText: 'Oui, changer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/plaintes/' + id + '/changer-statut',
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
            // CLÔTURER UNE PLAINTE
            // ============================================
            $(document).on('click', '.btn-cloturer-plainte', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Clôturer la plainte',
                    text: 'Voulez-vous vraiment clôturer cette plainte ?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2E8B57',
                    cancelButtonColor: '#6B8A7E',
                    confirmButtonText: 'Oui, clôturer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/plaintes/' + id + '/cloturer',
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
            $(document).on('click', '.btn-delete-plainte', function() {
                const id = $(this).data('id');
                const nom = $(this).data('nom');

                Swal.fire({
                    title: 'Confirmer la suppression',
                    html: `Voulez-vous vraiment supprimer la plainte de <strong>${nom}</strong> ?<br><small class="text-muted">Cette action est irréversible.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DC3545',
                    cancelButtonColor: '#6B8A7E',
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/plaintes/' + id,
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
                    url: '/plaintes/filter',
                    method: 'GET',
                    data: { statut: statut },
                    success: function(response) {
                        if (response.success) {
                            $('#plainte-table-body').html(response.html);
                            $('#plainte-count').text(response.count);
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
                $('#search-plainte').val('');
                applyFilters();
            });

            // ============================================
            // RECHERCHE
            // ============================================
            $('#btn-search').on('click', function() {
                const query = $('#search-plainte').val();

                if (!query) {
                    applyFilters();
                    return;
                }

                $.ajax({
                    url: '/plaintes/search',
                    method: 'GET',
                    data: { q: query },
                    success: function(response) {
                        if (response.success) {
                            $('#plainte-table-body').html(response.html);
                            $('#plainte-count').text(response.count);
                        }
                    }
                });
            });

            $('#search-plainte').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btn-search').click();
                }
            });

            // ============================================
            // RESET MODAL
            // ============================================
            function resetModal() {
                $('#plainte-form')[0].reset();
                $('#plainte-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#plainte_id').val('');
                $('#form-method').val('POST');
            }

        });
    </script>
@endpush
