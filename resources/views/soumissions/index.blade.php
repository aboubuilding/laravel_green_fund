@extends('layouts.app')

@section('title', 'Gestion des soumissions')

@section('page_title', 'Gestion des soumissions')
@section('page_icon', 'fa-upload')

@section('breadcrumb')
    <li class="active">Soumissions</li>
@endsection

@section('page_actions')
    <button class="btn-tgf-primary btn-sm" id="btn-new-soumission">
        <i class="fas fa-plus"></i> Nouvelle soumission
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
                            <i class="fas fa-store"></i> Guichet
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item filter-guichet active" href="#" data-value="">Tous</a></li>
                            @foreach($guichets as $guichet)
                                <li><a class="dropdown-item filter-guichet" href="#" data-value="{{ $guichet->id }}">{{ $guichet->nom }}</a></li>
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
                    <input type="text" class="form-control" id="search-soumission" placeholder="Rechercher...">
                    <button class="btn btn-outline-secondary" id="btn-search">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Statistiques --}}
        <div class="row g-4 mb-4">
            <div class="col-md-2 col-sm-4">
                <div class="stat-card-tgf" style="border-left-color: var(--tgf-primary);">
                    <div>
                        <p class="stat-number">{{ $stats['total'] }}</p>
                        <p class="stat-label">Total</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-4">
                <div class="stat-card-tgf" style="border-left-color: #ffc107;">
                    <div>
                        <p class="stat-number">{{ $stats['en_attente'] }}</p>
                        <p class="stat-label">En attente</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-4">
                <div class="stat-card-tgf" style="border-left-color: #007bff;">
                    <div>
                        <p class="stat-number">{{ $stats['en_cours'] }}</p>
                        <p class="stat-label">En cours</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #28a745;">
                    <div>
                        <p class="stat-number">{{ $stats['approuves'] }}</p>
                        <p class="stat-label">Approuvés</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #dc3545;">
                    <div>
                        <p class="stat-number">{{ $stats['rejetes'] }}</p>
                        <p class="stat-label">Rejetés</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau --}}
        <div class="card-tgf">
            <div class="card-header">
                <i class="fas fa-list card-title-icon"></i>
                Liste des soumissions
                <span class="badge bg-primary ms-2" id="soumission-count">{{ $soumissions->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-tgf mb-0">
                        <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Titre du projet</th>
                            <th>Porteur</th>
                            <th>Guichet</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="soumission-table-body">
                        @include('soumissions._rows', ['soumissions' => $soumissions])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL SOUMISSION --}}
    @include('soumissions._modal')

    {{-- MODAL CHANGER STATUT --}}
    @include('soumissions._statut')

    {{-- MODAL DÉTAIL --}}
    @include('soumissions._detail')

@endsection

@push('js')
    <script>
        $(document).ready(function() {

            // ============================================
            // OUVERTURE MODAL - CRÉATION
            // ============================================
            $('#btn-new-soumission').on('click', function() {
                resetModal();
                $('#modal-title').text('Nouvelle soumission');
                $('#btn-submit-text').text('Créer');
                $('#form-method').val('POST');
                $('#soumission_id').val('');
                $('#soumission-form')[0].reset();
                $('#soumission-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#soumissionModal').modal('show');
            });

            // ============================================
            // OUVERTURE MODAL - DÉTAIL
            // ============================================
            $(document).on('click', '.btn-show-soumission', function() {
                const id = $(this).data('id');

                $.ajax({
                    url: '/soumissions/' + id,
                    method: 'GET',
                    success: function(data) {
                        if (data.success) {
                            const s = data.soumission;
                            $('#detail-soumission-ref').text(s.numero_soumission);
                            $('#detail-soumission-titre').text(s.titre_projet);
                            $('#detail-soumission-porteur').text(s.porteur_nom);
                            $('#detail-soumission-email').text(s.porteur_email);
                            $('#detail-soumission-telephone').text(s.porteur_telephone || '-');
                            $('#detail-soumission-guichet').text(s.nom_guichet);
                            $('#detail-soumission-region').text(s.nom_region);
                            $('#detail-soumission-montant').text(s.montant_sollicite ? new Intl.NumberFormat('fr-FR').format(s.montant_sollicite) + ' FCFA' : '-');
                            $('#detail-soumission-cout').text(s.cout_global ? new Intl.NumberFormat('fr-FR').format(s.cout_global) + ' FCFA' : '-');
                            $('#detail-soumission-resume').text(s.resume_projet || '-');
                            $('#detail-soumission-statut').html(`
                        <span class="badge badge-tgf-${s.statut_badge}">
                            <i class="fas ${s.statut_icon}"></i>
                            ${s.statut_label}
                        </span>
                    `);
                            $('#detail-soumission-progression').html(`
                        <div class="progress" style="height: 10px; width: 200px;">
                            <div class="progress-bar bg-${s.statut_badge}" style="width: ${s.progression}%">${s.progression}%</div>
                        </div>
                    `);
                            $('#detail-soumission-date').text(s.date_soumission_formatee);
                            $('#detail-soumission-id').val(s.id);

                            // Historiques
                            let html = '';
                            data.historiques.forEach(function(h) {
                                html += `
                            <div class="d-flex gap-3 mb-2 p-2 bg-light rounded">
                                <div>
                                    <span class="badge badge-tgf-${h.statut_badge}">${h.statut_label}</span>
                                </div>
                                <div>
                                    <div class="small">${h.commentaire || 'Aucun commentaire'}</div>
                                    <small class="text-muted">${h.date_action_formatee} par ${h.auteur ? h.auteur.nom : 'Système'}</small>
                                </div>
                            </div>
                        `;
                            });

                            if (data.historiques.length === 0) {
                                html = '<p class="text-muted">Aucun historique</p>';
                            }

                            $('#detail-soumission-historiques').html(html);
                            $('#detailSoumissionModal').modal('show');
                        }
                    }
                });
            });

            // ============================================
            // OUVERTURE MODAL - CHANGER STATUT
            // ============================================
            $(document).on('click', '.btn-changer-statut', function() {
                const id = $(this).data('id');
                const statut = $(this).data('statut');
                const label = $(this).data('label');

                $('#statut-soumission-id').val(id);
                $('#statut-select').val(statut);
                $('#statut-label').text(label);
                $('#statut-commentaire').val('');
                $('#statutModal').modal('show');
            });

            // ============================================
            // SOUMISSION CHANGEMENT STATUT
            // ============================================
            $('#statut-form').on('submit', function(e) {
                e.preventDefault();

                const id = $('#statut-soumission-id').val();
                const statut = $('#statut-select').val();
                const commentaire = $('#statut-commentaire').val();

                const btn = $('#btn-statut');
                const originalText = btn.html();
                btn.html('<i class="fas fa-spinner fa-spin"></i> Traitement...').prop('disabled', true);

                $.ajax({
                    url: '/soumissions/' + id + '/changer-statut',
                    method: 'POST',
                    data: { statut: statut, commentaire: commentaire },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        btn.html(originalText).prop('disabled', false);
                        if (response.success) {
                            toastr.success(response.message);
                            $('#statutModal').modal('hide');
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        }
                    },
                    error: function() {
                        btn.html(originalText).prop('disabled', false);
                        toastr.error('Erreur lors du changement de statut.');
                    }
                });
            });

            // ============================================
            // SOUMISSION FORMULAIRE
            // ============================================
            $('#soumission-form').on('submit', function(e) {
                e.preventDefault();

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();

                const form = $(this);
                const formData = new FormData(this);
                const id = $('#soumission_id').val();
                const url = id ? '/soumissions/' + id : '/soumissions';

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
                            $('#soumissionModal').modal('hide');
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
            $(document).on('click', '.btn-delete-soumission', function() {
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
                            url: '/soumissions/' + id,
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
                const statut = $('.filter-statut.active').data('value') || '';
                const guichet = $('.filter-guichet.active').data('value') || '';

                $.ajax({
                    url: '/soumissions/filter',
                    method: 'GET',
                    data: { statut: statut, guichet: guichet },
                    success: function(response) {
                        if (response.success) {
                            $('#soumission-table-body').html(response.html);
                            $('#soumission-count').text(response.count);
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

            $('.filter-guichet').on('click', function(e) {
                e.preventDefault();
                $('.filter-guichet').removeClass('active');
                $(this).addClass('active');
                applyFilters();
            });

            $('#btn-reset-filters').on('click', function() {
                $('.filter-statut, .filter-guichet').removeClass('active');
                $('.filter-statut[data-value=""]').addClass('active');
                $('.filter-guichet[data-value=""]').addClass('active');
                $('#search-soumission').val('');
                applyFilters();
            });

            // ============================================
            // RECHERCHE
            // ============================================
            $('#btn-search').on('click', function() {
                const query = $('#search-soumission').val();

                if (!query) {
                    applyFilters();
                    return;
                }

                $.ajax({
                    url: '/soumissions/search',
                    method: 'GET',
                    data: { q: query },
                    success: function(response) {
                        if (response.success) {
                            $('#soumission-table-body').html(response.html);
                            $('#soumission-count').text(response.count);
                        }
                    }
                });
            });

            $('#search-soumission').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btn-search').click();
                }
            });

            // ============================================
            // RESET MODAL
            // ============================================
            function resetModal() {
                $('#soumission-form')[0].reset();
                $('#soumission-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#soumission_id').val('');
                $('#form-method').val('POST');
                $('#file-info').hide();
            }

            // ============================================
            // APERÇU DU FICHIER
            // ============================================
            $('.doc-file-input').on('change', function() {
                const file = this.files[0];
                const container = $(this).closest('.doc-container').find('.file-info');
                if (file) {
                    container.show();
                    container.find('.file-name').text(file.name);
                    container.find('.file-size').text((file.size / 1024).toFixed(1) + ' Ko');
                } else {
                    container.hide();
                }
            });

        });
    </script>
@endpush
