@extends('layouts.app')

@section('title', 'Gestion des manifestations d\'intérêt')

@section('page_title', 'Manifestations d\'intérêt')
@section('page_icon', 'fa-envelope')

@section('breadcrumb')
    <li class="active">Manifestations</li>
@endsection

@section('page_actions')
    <button class="btn-tgf-primary btn-sm" id="btn-new-manifestation">
        <i class="fas fa-plus"></i> Nouvelle manifestation
    </button>
    <a href="{{ route('manifestations.export') }}" class="btn-tgf-outline-primary btn-sm">
        <i class="fas fa-file-export"></i> Exporter (CSV)
    </a>
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

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-tag"></i> Domaine
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item filter-domaine active" href="#" data-value="">Tous</a></li>
                            @foreach($domaines as $domaine)
                                <li><a class="dropdown-item filter-domaine" href="#" data-value="{{ $domaine->id }}">{{ $domaine->libelle }}</a></li>
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
                    <input type="text" class="form-control" id="search-manifestation" placeholder="Rechercher...">
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
                            <p class="stat-label">Total manifestations</p>
                        </div>
                        <div class="stat-icon bg-tgf-primary-light">
                            <i class="fas fa-envelope text-tgf-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card-tgf" style="border-left-color: #DC3545;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['nouvelles'] }}</p>
                            <p class="stat-label">Nouvelles</p>
                        </div>
                        <div class="stat-icon" style="background: rgba(220, 53, 69, 0.1);">
                            <i class="fas fa-envelope text-tgf-danger"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card-tgf" style="border-left-color: #2E8B57;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['traitees'] }}</p>
                            <p class="stat-label">Traitées</p>
                        </div>
                        <div class="stat-icon" style="background: rgba(46, 139, 87, 0.1);">
                            <i class="fas fa-check-double text-tgf-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau --}}
        <div class="card-tgf">
            <div class="card-header">
                <i class="fas fa-list card-title-icon"></i>
                Liste des manifestations
                <span class="badge bg-primary ms-2" id="manifestation-count">{{ $manifestations->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-tgf mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Porteur</th>
                            <th>Contact</th>
                            <th>Type</th>
                            <th>Guichet/Domaine</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="manifestation-table-body">
                        @include('manifestations._rows', ['manifestations' => $manifestations])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL MANIFESTATION --}}
    @include('manifestations._modal')

    {{-- MODAL DÉTAIL --}}
    @include('manifestations._detail')

    {{-- MODAL EMAIL --}}
    @include('manifestations._email')

@endsection

@push('js')
    <script>
        $(document).ready(function() {

            // ============================================
            // OUVERTURE MODAL - CRÉATION
            // ============================================
            $('#btn-new-manifestation').on('click', function() {
                resetModal();
                $('#modal-title').text('Nouvelle manifestation');
                $('#btn-submit-text').text('Créer');
                $('#form-method').val('POST');
                $('#manifestation_id').val('');
                $('#manifestation-form')[0].reset();
                $('#manifestation-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#file-required').show();
                $('#document_manifestation').prop('required', true);
                $('#manifestationModal').modal('show');
            });

            // ============================================
            // OUVERTURE MODAL - DÉTAIL
            // ============================================
            $(document).on('click', '.btn-show-manifestation', function() {
                const id = $(this).data('id');

                $.ajax({
                    url: '/manifestations/' + id,
                    method: 'GET',
                    success: function(data) {
                        if (data.success) {
                            const m = data.manifestation;
                            $('#detail-manifestation-nom').text(m.nom_complet);
                            $('#detail-manifestation-email').text(m.email || '-');
                            $('#detail-manifestation-telephone').text(m.telephone || '-');
                            $('#detail-manifestation-type').text(m.type_organisation_label || '-');
                            $('#detail-manifestation-guichet').text(m.nom_guichet);
                            $('#detail-manifestation-domaine').text(m.domaine_interet_libelle);
                            $('#detail-manifestation-message').text(m.message || '-');
                            $('#detail-manifestation-statut').html(`
                        <span class="badge badge-tgf-${m.statut_badge}">
                            <i class="fas ${m.statut_icon}"></i>
                            ${m.statut_label}
                        </span>
                    `);
                            $('#detail-manifestation-date').text(m.date_formatee);
                            $('#detail-manifestation-id').val(m.id);

                            if (m.document_manifestation) {
                                $('#detail-manifestation-document').show().find('a').attr('href', m.document_url);
                            } else {
                                $('#detail-manifestation-document').hide();
                            }

                            $('#detailManifestationModal').modal('show');
                        }
                    }
                });
            });

            // ============================================
            // OUVERTURE MODAL - ÉDITION
            // ============================================
            $(document).on('click', '.btn-edit-manifestation', function() {
                const id = $(this).data('id');

                resetModal();
                $('#modal-title').text('Modifier la manifestation');
                $('#btn-submit-text').text('Mettre à jour');
                $('#form-method').val('PUT');

                $.ajax({
                    url: '/manifestations/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        if (data.success) {
                            $('#manifestation_id').val(data.id);
                            $('#nom').val(data.nom);
                            $('#prenom').val(data.prenom);
                            $('#email').val(data.email);
                            $('#telephone').val(data.telephone);
                            $('#type_organisation').val(data.type_organisation);
                            $('#guichet_id').val(data.guichet_id);
                            $('#domaine_interet_id').val(data.domaine_interet_id);
                            $('#message').val(data.message);
                            $('#statut_manifestation').val(data.statut_manifestation);
                            $('#file-required').hide();
                            $('#document_manifestation').prop('required', false);
                            $('#manifestation-form .is-invalid').removeClass('is-invalid');
                            $('.invalid-feedback').removeClass('show').empty();
                            $('#manifestationModal').modal('show');
                        }
                    },
                    error: function() {
                        toastr.error('Erreur lors du chargement des données.');
                    }
                });
            });

            // ============================================
            // OUVERTURE MODAL - EMAIL
            // ============================================
            $(document).on('click', '.btn-email-manifestation', function() {
                const id = $(this).data('id');
                const email = $(this).data('email');
                const nom = $(this).data('nom');

                $('#email-manifestation-id').val(id);
                $('#email-destinataire').text(email);
                $('#email-nom').text(nom);
                $('#email-sujet').val('Suite à votre manifestation d\'intérêt');
                $('#email-contenu').val('');
                $('#emailModal').modal('show');
            });

            // ============================================
            // SOUMISSION FORMULAIRE
            // ============================================
            $('#manifestation-form').on('submit', function(e) {
                e.preventDefault();

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();

                const form = $(this);
                const formData = new FormData(this);
                const id = $('#manifestation_id').val();
                const url = id ? '/manifestations/' + id : '/manifestations';

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
                            $('#manifestationModal').modal('hide');
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
            // SOUMISSION EMAIL
            // ============================================
            $('#email-form').on('submit', function(e) {
                e.preventDefault();

                const id = $('#email-manifestation-id').val();
                const sujet = $('#email-sujet').val();
                const contenu = $('#email-contenu').val();

                if (!sujet || !contenu) {
                    toastr.warning('Veuillez remplir tous les champs.');
                    return;
                }

                const btn = $('#btn-email');
                const originalText = btn.html();
                btn.html('<i class="fas fa-spinner fa-spin"></i> Envoi...').prop('disabled', true);

                $.ajax({
                    url: '/manifestations/' + id + '/email',
                    method: 'POST',
                    data: { sujet: sujet, contenu: contenu },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        btn.html(originalText).prop('disabled', false);

                        if (response.success) {
                            toastr.success(response.message);
                            $('#emailModal').modal('hide');
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        btn.html(originalText).prop('disabled', false);
                        toastr.error('Erreur lors de l\'envoi de l\'email.');
                    }
                });
            });

            // ============================================
            // TRAITER UNE MANIFESTATION
            // ============================================
            $(document).on('click', '.btn-traiter-manifestation', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Confirmer',
                    text: 'Voulez-vous marquer cette manifestation comme traitée ?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2E8B57',
                    cancelButtonColor: '#6B8A7E',
                    confirmButtonText: 'Oui, traiter',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/manifestations/' + id + '/traiter',
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
                                toastr.error('Erreur lors du traitement.');
                            }
                        });
                    }
                });
            });

            // ============================================
            // SUPPRESSION
            // ============================================
            $(document).on('click', '.btn-delete-manifestation', function() {
                const id = $(this).data('id');
                const nom = $(this).data('nom');

                Swal.fire({
                    title: 'Confirmer la suppression',
                    html: `Voulez-vous vraiment supprimer la manifestation de <strong>${nom}</strong> ?<br><small class="text-muted">Cette action est irréversible.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DC3545',
                    cancelButtonColor: '#6B8A7E',
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/manifestations/' + id,
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
                const domaine = $('.filter-domaine.active').data('value') || '';

                $.ajax({
                    url: '/manifestations/filter',
                    method: 'GET',
                    data: { statut: statut, guichet: guichet, domaine: domaine },
                    success: function(response) {
                        if (response.success) {
                            $('#manifestation-table-body').html(response.html);
                            $('#manifestation-count').text(response.count);
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

            $('.filter-domaine').on('click', function(e) {
                e.preventDefault();
                $('.filter-domaine').removeClass('active');
                $(this).addClass('active');
                applyFilters();
            });

            $('#btn-reset-filters').on('click', function() {
                $('.filter-statut, .filter-guichet, .filter-domaine').removeClass('active');
                $('.filter-statut[data-value=""]').addClass('active');
                $('.filter-guichet[data-value=""]').addClass('active');
                $('.filter-domaine[data-value=""]').addClass('active');
                $('#search-manifestation').val('');
                applyFilters();
            });

            // ============================================
            // RECHERCHE
            // ============================================
            $('#btn-search').on('click', function() {
                const query = $('#search-manifestation').val();

                if (!query) {
                    applyFilters();
                    return;
                }

                $.ajax({
                    url: '/manifestations/search',
                    method: 'GET',
                    data: { q: query },
                    success: function(response) {
                        if (response.success) {
                            $('#manifestation-table-body').html(response.html);
                            $('#manifestation-count').text(response.count);
                        }
                    }
                });
            });

            $('#search-manifestation').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btn-search').click();
                }
            });

            // ============================================
            // RESET MODAL
            // ============================================
            function resetModal() {
                $('#manifestation-form')[0].reset();
                $('#manifestation-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#manifestation_id').val('');
                $('#form-method').val('POST');
                $('#file-info').hide();
            }

            // ============================================
            // APERÇU DU FICHIER
            // ============================================
            $('#document_manifestation').on('change', function() {
                const file = this.files[0];
                if (file) {
                    $('#file-info').show();
                    $('#file-name').text(file.name);
                    $('#file-size').text((file.size / 1024).toFixed(1) + ' Ko');
                } else {
                    $('#file-info').hide();
                }
            });

        });
    </script>
@endpush
