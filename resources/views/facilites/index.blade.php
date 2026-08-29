@extends('layouts.app')

@section('title', 'Gestion des facilités')

@section('page_title', 'Gestion des facilités')
@section('page_icon', 'fa-hand-holding-heart')

@section('breadcrumb')
    <li class="active">Facilités</li>
@endsection

@section('page_actions')
    <button class="btn-tgf-primary btn-sm" id="btn-new-facilite">
        <i class="fas fa-plus"></i> Nouvelle facilité
    </button>
@endsection

@section('contenu')

    <div class="container-fluid px-0">

        {{-- Statistiques --}}
        <div class="row g-4 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: var(--tgf-primary);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['total'] }}</p>
                            <p class="stat-label">Total facilités</p>
                        </div>
                        <div class="stat-icon bg-tgf-primary-light">
                            <i class="fas fa-hand-holding-heart text-tgf-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
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

            <div class="col-md-3 col-sm-6">
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

            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #6B46C1;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['total_projets'] }}</p>
                            <p class="stat-label">Projets associés</p>
                        </div>
                        <div class="stat-icon" style="background: rgba(107, 70, 193, 0.1);">
                            <i class="fas fa-project-diagram" style="color: #6B46C1;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau --}}
        <div class="card-tgf">
            <div class="card-header">
                <i class="fas fa-list card-title-icon"></i>
                Liste des facilités
                <span class="badge bg-primary ms-2" id="facilite-count">{{ $facilites->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-tgf mb-0">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Projets</th>
                            <th>Statut</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="facilite-table-body">
                        @include('facilites._rows', ['facilites' => $facilites])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL FACILITÉ --}}
    @include('facilites._modal')

    {{-- MODAL CHIFFRES CLÉS --}}
    @include('facilites._chiffres')

    {{-- MODAL PROJETS --}}
    @include('facilites._projets')

@endsection

@push('js')
    <script>
        $(document).ready(function() {

            // ============================================
            // OUVERTURE MODAL - CRÉATION FACILITÉ
            // ============================================
            $('#btn-new-facilite').on('click', function() {
                resetFaciliteModal();
                $('#modal-title').text('Nouvelle facilité');
                $('#btn-submit-text').text('Créer');
                $('#form-method').val('POST');
                $('#facilite_id').val('');
                $('#facilite-form')[0].reset();
                $('#facilite-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#faciliteModal').modal('show');
            });

            // ============================================
            // OUVERTURE MODAL - ÉDITION FACILITÉ
            // ============================================
            $(document).on('click', '.btn-edit-facilite', function() {
                const id = $(this).data('id');

                resetFaciliteModal();
                $('#modal-title').text('Modifier la facilité');
                $('#btn-submit-text').text('Mettre à jour');
                $('#form-method').val('PUT');

                $.ajax({
                    url: '/facilites/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        $('#facilite_id').val(data.id);
                        $('#nom').val(data.nom);
                        $('#slug').val(data.slug);
                        $('#description').val(data.description);
                        $('#facilite-form .is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').removeClass('show').empty();
                        $('#faciliteModal').modal('show');
                    },
                    error: function() {
                        toastr.error('Erreur lors du chargement des données.');
                    }
                });
            });

            // ============================================
            // SOUMISSION FORMULAIRE FACILITÉ (AJAX)
            // ============================================
            $('#facilite-form').on('submit', function(e) {
                e.preventDefault();

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();

                const form = $(this);
                const formData = form.serialize();
                const id = $('#facilite_id').val();
                const url = id ? '/facilites/' + id : '/facilites';

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
                            $('#faciliteModal').modal('hide');
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
            // SUPPRESSION FACILITÉ
            // ============================================
            $(document).on('click', '.btn-delete-facilite', function() {
                const id = $(this).data('id');
                const nom = $(this).data('nom');

                Swal.fire({
                    title: 'Confirmer la suppression',
                    html: `Voulez-vous vraiment supprimer <strong>${nom}</strong> ?<br><small class="text-muted">Cette action est irréversible.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DC3545',
                    cancelButtonColor: '#6B8A7E',
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/facilites/' + id,
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
            // GESTION DES CHIFFRES CLÉS
            // ============================================
            $(document).on('click', '.btn-chiffres', function() {
                const id = $(this).data('id');

                $.ajax({
                    url: '/facilites/' + id,
                    method: 'GET',
                    success: function(data) {
                        if (data.success) {
                            $('#chiffres-facilite-id').val(id);
                            $('#chiffres-facilite-nom').text(data.facilite.nom);

                            let html = '';
                            data.chiffres.forEach(function(chiffre) {
                                html += `
                            <tr id="chiffre-row-${chiffre.id}">
                                <td><strong>${chiffre.valeur}</strong></td>
                                <td>${chiffre.libelle}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-primary btn-edit-chiffre"
                                                data-id="${chiffre.id}"
                                                data-valeur="${chiffre.valeur}"
                                                data-libelle="${chiffre.libelle}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger btn-delete-chiffre"
                                                data-id="${chiffre.id}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                            });

                            if (data.chiffres.length === 0) {
                                html = `<tr><td colspan="3" class="text-center text-muted py-3">Aucun chiffre clé</td></tr>`;
                            }

                            $('#chiffres-table-body').html(html);
                            $('#chiffresModal').modal('show');
                        }
                    }
                });
            });

            // Ajout chiffre clé
            $('#btn-add-chiffre').on('click', function() {
                const faciliteId = $('#chiffres-facilite-id').val();
                const valeur = $('#chiffre-valeur').val();
                const libelle = $('#chiffre-libelle').val();

                if (!valeur || !libelle) {
                    toastr.warning('Veuillez remplir tous les champs.');
                    return;
                }

                $.ajax({
                    url: '/facilites/' + faciliteId + '/chiffres',
                    method: 'POST',
                    data: { valeur: valeur, libelle: libelle },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#chiffre-valeur').val('');
                            $('#chiffre-libelle').val('');
                            $('.btn-chiffres[data-id="' + faciliteId + '"]').click();
                        }
                    },
                    error: function() {
                        toastr.error('Erreur lors de l\'ajout.');
                    }
                });
            });

            // Édition chiffre clé
            $(document).on('click', '.btn-edit-chiffre', function() {
                const id = $(this).data('id');
                const valeur = $(this).data('valeur');
                const libelle = $(this).data('libelle');

                $('#edit-chiffre-id').val(id);
                $('#edit-chiffre-valeur').val(valeur);
                $('#edit-chiffre-libelle').val(libelle);
                $('#editChiffreModal').modal('show');
            });

            // Soumission édition chiffre
            $('#edit-chiffre-form').on('submit', function(e) {
                e.preventDefault();

                const id = $('#edit-chiffre-id').val();
                const valeur = $('#edit-chiffre-valeur').val();
                const libelle = $('#edit-chiffre-libelle').val();

                $.ajax({
                    url: '/facilites/chiffres/' + id,
                    method: 'PUT',
                    data: { valeur: valeur, libelle: libelle },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#editChiffreModal').modal('hide');
                            const faciliteId = $('#chiffres-facilite-id').val();
                            $('.btn-chiffres[data-id="' + faciliteId + '"]').click();
                        }
                    },
                    error: function() {
                        toastr.error('Erreur lors de la mise à jour.');
                    }
                });
            });

            // Suppression chiffre clé
            $(document).on('click', '.btn-delete-chiffre', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Confirmer la suppression',
                    text: 'Voulez-vous vraiment supprimer ce chiffre clé ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DC3545',
                    cancelButtonColor: '#6B8A7E',
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/facilites/chiffres/' + id,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            success: function(response) {
                                if (response.success) {
                                    toastr.success(response.message);
                                    const faciliteId = $('#chiffres-facilite-id').val();
                                    $('.btn-chiffres[data-id="' + faciliteId + '"]').click();
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
            // GESTION DES PROJETS ASSOCIÉS
            // ============================================
            $(document).on('click', '.btn-projets', function() {
                const id = $(this).data('id');

                $.ajax({
                    url: '/facilites/' + id,
                    method: 'GET',
                    success: function(data) {
                        if (data.success) {
                            $('#projets-facilite-id').val(id);
                            $('#projets-facilite-nom').text(data.facilite.nom);

                            // Projets associés
                            let html = '';
                            data.projets.forEach(function(projet) {
                                html += `
                            <tr>
                                <td>${projet.titre}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger btn-detach-projet"
                                            data-facilite="${id}"
                                            data-projet="${projet.id}">
                                        <i class="fas fa-unlink"></i> Dissocier
                                    </button>
                                </td>
                            </tr>
                        `;
                            });

                            if (data.projets.length === 0) {
                                html = `<tr><td colspan="2" class="text-center text-muted py-3">Aucun projet associé</td></tr>`;
                            }

                            $('#projets-associes-body').html(html);

                            // Projets disponibles
                            let availableHtml = '';
                            data.all_projets.forEach(function(projet) {
                                const isAssociated = data.projets.some(p => p.id === projet.id);
                                if (!isAssociated) {
                                    availableHtml += `
                                <tr>
                                    <td>${projet.titre}</td>
                                    <td>
                                        <button class="btn btn-sm btn-success btn-attach-projet"
                                                data-facilite="${id}"
                                                data-projet="${projet.id}">
                                            <i class="fas fa-link"></i> Associer
                                        </button>
                                    </td>
                                </tr>
                            `;
                                }
                            });

                            if (availableHtml === '') {
                                availableHtml = `<tr><td colspan="2" class="text-center text-muted py-3">Tous les projets sont déjà associés</td></tr>`;
                            }

                            $('#projets-disponibles-body').html(availableHtml);
                            $('#projetsModal').modal('show');
                        }
                    }
                });
            });

            // Associer un projet
            $(document).on('click', '.btn-attach-projet', function() {
                const faciliteId = $(this).data('facilite');
                const projetId = $(this).data('projet');

                $.ajax({
                    url: '/facilites/' + faciliteId + '/attach/' + projetId,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('.btn-projets[data-id="' + faciliteId + '"]').click();
                        }
                    },
                    error: function() {
                        toastr.error('Erreur lors de l\'association.');
                    }
                });
            });

            // Dissocier un projet
            $(document).on('click', '.btn-detach-projet', function() {
                const faciliteId = $(this).data('facilite');
                const projetId = $(this).data('projet');

                Swal.fire({
                    title: 'Confirmer',
                    text: 'Voulez-vous vraiment dissocier ce projet ?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#DC3545',
                    cancelButtonColor: '#6B8A7E',
                    confirmButtonText: 'Oui, dissocier',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/facilites/' + faciliteId + '/detach/' + projetId,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            success: function(response) {
                                if (response.success) {
                                    toastr.success(response.message);
                                    $('.btn-projets[data-id="' + faciliteId + '"]').click();
                                }
                            },
                            error: function() {
                                toastr.error('Erreur lors de la dissociation.');
                            }
                        });
                    }
                });
            });

            // ============================================
            // RESET MODAL FACILITÉ
            // ============================================
            function resetFaciliteModal() {
                $('#facilite-form')[0].reset();
                $('#facilite-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#facilite_id').val('');
                $('#form-method').val('POST');
            }

        });
    </script>
@endpush
