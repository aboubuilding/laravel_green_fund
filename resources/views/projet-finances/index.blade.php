@extends('layouts.app')

@section('title', 'Gestion des projets financés')

@section('page_title', 'Projets financés')
@section('page_icon', 'fa-star')

@section('breadcrumb')
    <li class="active">Projets financés</li>
@endsection

@section('page_actions')
    <button class="btn-tgf-primary btn-sm" id="btn-new-projet-finance">
        <i class="fas fa-plus"></i> Nouveau projet financé
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
                            <i class="fas fa-calendar"></i> Année
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item filter-annee active" href="#" data-value="">Toutes</a></li>
                            @foreach($annees as $annee)
                                <li><a class="dropdown-item filter-annee" href="#" data-value="{{ $annee }}">{{ $annee }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-handshake"></i> Partenaire
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item filter-partenaire active" href="#" data-value="">Tous</a></li>
                            @foreach($partenaires as $partenaire)
                                <li><a class="dropdown-item filter-partenaire" href="#" data-value="{{ $partenaire->id }}">{{ $partenaire->nom }}</a></li>
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
                    <input type="text" class="form-control" id="search-projet-finance" placeholder="Rechercher...">
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
                            <i class="fas fa-star text-tgf-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #F5A623;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['mise_en_avant'] }}</p>
                            <p class="stat-label">Mis en avant</p>
                        </div>
                        <div class="stat-icon bg-tgf-accent-light">
                            <i class="fas fa-crown text-tgf-accent"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #2E8B57;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ number_format($stats['montant_total'], 0, ',', ' ') }}</p>
                            <p class="stat-label">Montant total (FCFA)</p>
                        </div>
                        <div class="stat-icon" style="background: rgba(46, 139, 87, 0.1);">
                            <i class="fas fa-money-bill text-tgf-success"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #6B46C1;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ count($stats['annees']) }}</p>
                            <p class="stat-label">Années couvertes</p>
                        </div>
                        <div class="stat-icon" style="background: rgba(107, 70, 193, 0.1);">
                            <i class="fas fa-calendar" style="color: #6B46C1;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau --}}
        <div class="card-tgf">
            <div class="card-header">
                <i class="fas fa-list card-title-icon"></i>
                Liste des projets financés
                <span class="badge bg-primary ms-2" id="projet-finance-count">{{ $projetFinances->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-tgf mb-0">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Montant</th>
                            <th>Partenaire</th>
                            <th>Année</th>
                            <th>Mise en avant</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="projet-finance-table-body">
                        @include('projet-finances._rows', ['projetFinances' => $projetFinances])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL PROJET FINANCÉ --}}
    @include('projet-finances._modal')

@endsection

@push('js')
    <script>
        $(document).ready(function() {

            // ============================================
            // OUVERTURE MODAL - CRÉATION
            // ============================================
            $('#btn-new-projet-finance').on('click', function() {
                resetModal();
                $('#modal-title').text('Nouveau projet financé');
                $('#btn-submit-text').text('Créer');
                $('#form-method').val('POST');
                $('#projet_finance_id').val('');
                $('#projet-finance-form')[0].reset();
                $('#projet-finance-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#projetFinanceModal').modal('show');
            });

            // ============================================
            // OUVERTURE MODAL - ÉDITION
            // ============================================
            $(document).on('click', '.btn-edit-projet-finance', function() {
                const id = $(this).data('id');

                resetModal();
                $('#modal-title').text('Modifier le projet financé');
                $('#btn-submit-text').text('Mettre à jour');
                $('#form-method').val('PUT');

                $.ajax({
                    url: '/projet-finances/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        if (data.success) {
                            $('#projet_finance_id').val(data.id);
                            $('#projet_id').val(data.projet_id);
                            $('#montant_finance').val(data.montant_finance);
                            $('#partenaire_id').val(data.partenaire_id);
                            $('#annee').val(data.annee);
                            if (data.mise_en_avant) {
                                $('#mise_en_avant').prop('checked', true);
                            }
                            $('#projet-finance-form .is-invalid').removeClass('is-invalid');
                            $('.invalid-feedback').removeClass('show').empty();
                            $('#projetFinanceModal').modal('show');
                        }
                    },
                    error: function() {
                        toastr.error('Erreur lors du chargement des données.');
                    }
                });
            });

            // ============================================
            // SOUMISSION FORMULAIRE
            // ============================================
            $('#projet-finance-form').on('submit', function(e) {
                e.preventDefault();

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();

                const form = $(this);
                const formData = form.serialize();
                const id = $('#projet_finance_id').val();
                const url = id ? '/projet-finances/' + id : '/projet-finances';

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
                            $('#projetFinanceModal').modal('hide');
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
            // TOGGLE MISE EN AVANT
            // ============================================
            $(document).on('click', '.btn-toggle-mise-en-avant', function() {
                const id = $(this).data('id');
                const isMiseEnAvant = $(this).data('mise-en-avant') === 1;

                Swal.fire({
                    title: 'Confirmer',
                    html: isMiseEnAvant
                        ? 'Voulez-vous retirer ce projet de la mise en avant ?'
                        : 'Voulez-vous mettre ce projet en avant ?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: isMiseEnAvant ? '#DC3545' : '#F5A623',
                    cancelButtonColor: '#6B8A7E',
                    confirmButtonText: isMiseEnAvant ? 'Oui, retirer' : 'Oui, mettre en avant',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/projet-finances/' + id + '/toggle-mise-en-avant',
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
                                toastr.error('Erreur lors de la mise à jour.');
                            }
                        });
                    }
                });
            });

            // ============================================
            // SUPPRESSION
            // ============================================
            $(document).on('click', '.btn-delete-projet-finance', function() {
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
                            url: '/projet-finances/' + id,
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
                const annee = $('.filter-annee.active').data('value') || '';
                const partenaire = $('.filter-partenaire.active').data('value') || '';

                $.ajax({
                    url: '/projet-finances/filter',
                    method: 'GET',
                    data: { annee: annee, partenaire: partenaire },
                    success: function(response) {
                        if (response.success) {
                            $('#projet-finance-table-body').html(response.html);
                            $('#projet-finance-count').text(response.count);
                        }
                    }
                });
            }

            $('.filter-annee').on('click', function(e) {
                e.preventDefault();
                $('.filter-annee').removeClass('active');
                $(this).addClass('active');
                applyFilters();
            });

            $('.filter-partenaire').on('click', function(e) {
                e.preventDefault();
                $('.filter-partenaire').removeClass('active');
                $(this).addClass('active');
                applyFilters();
            });

            $('#btn-reset-filters').on('click', function() {
                $('.filter-annee, .filter-partenaire').removeClass('active');
                $('.filter-annee[data-value=""]').addClass('active');
                $('.filter-partenaire[data-value=""]').addClass('active');
                $('#search-projet-finance').val('');
                applyFilters();
            });

            // ============================================
            // RECHERCHE
            // ============================================
            $('#btn-search').on('click', function() {
                const query = $('#search-projet-finance').val();

                if (!query) {
                    applyFilters();
                    return;
                }

                $.ajax({
                    url: '/projet-finances/search',
                    method: 'GET',
                    data: { q: query },
                    success: function(response) {
                        if (response.success) {
                            $('#projet-finance-table-body').html(response.html);
                            $('#projet-finance-count').text(response.count);
                        }
                    }
                });
            });

            $('#search-projet-finance').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btn-search').click();
                }
            });

            // ============================================
            // RESET MODAL
            // ============================================
            function resetModal() {
                $('#projet-finance-form')[0].reset();
                $('#projet-finance-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#projet_finance_id').val('');
                $('#form-method').val('POST');
                $('#mise_en_avant').prop('checked', false);
            }

        });
    </script>
@endpush
