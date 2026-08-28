@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('page_title', 'Gestion des utilisateurs')
@section('page_icon', 'fa-users')

@section('breadcrumb')
    <li class="active">Utilisateurs</li>
@endsection

@section('page_actions')
    <button class="btn-tgf-primary btn-sm" id="btn-new-user">
        <i class="fas fa-plus"></i> Nouvel utilisateur
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
                            <p class="stat-label">Total utilisateurs</p>
                        </div>
                        <div class="stat-icon bg-tgf-primary-light">
                            <i class="fas fa-users text-tgf-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #F5A623;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['admins'] }}</p>
                            <p class="stat-label">Administrateurs</p>
                        </div>
                        <div class="stat-icon bg-tgf-accent-light">
                            <i class="fas fa-user-shield text-tgf-accent"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #2E8B57;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['users'] }}</p>
                            <p class="stat-label">Utilisateurs</p>
                        </div>
                        <div class="stat-icon" style="background: rgba(46, 139, 87, 0.1);">
                            <i class="fas fa-user text-tgf-success"></i>
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
                            <i class="fas fa-user-slash text-tgf-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableau --}}
        <div class="card-tgf">
            <div class="card-header">
                <i class="fas fa-list card-title-icon"></i>
                Liste des utilisateurs
                <span class="badge bg-primary ms-2">{{ $users->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-tgf mb-0">
                        <thead>
                        <tr>
                            <th>Utilisateur</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                            <tr id="user-row-{{ $user->id }}">
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-circle" style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(145deg, #F5A623, #D4891A); color: #fff; font-size: 14px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            {{ strtoupper(substr($user->nom, 0, 2)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $user->nom }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge badge-tgf-{{ $user->role_badge }}">
                                        <i class="fas {{ $user->role_icon }}"></i>
                                        {{ $user->role_label }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-tgf-{{ $user->statut_badge }}">
                                        {{ $user->statut_label }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <button class="btn btn-sm btn-primary btn-edit-user"
                                                data-id="{{ $user->id }}"
                                                data-nom="{{ $user->nom }}"
                                                data-email="{{ $user->email }}"
                                                data-role="{{ $user->role_id }}"
                                                data-statut="{{ $user->est_actif ? 1 : 0 }}"
                                                title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-{{ $user->est_actif ? 'warning' : 'success' }} btn-toggle-status"
                                                data-id="{{ $user->id }}"
                                                title="{{ $user->est_actif ? 'Désactiver' : 'Activer' }}">
                                            <i class="fas fa-{{ $user->est_actif ? 'user-slash' : 'user-check' }}"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger btn-delete-user"
                                                data-id="{{ $user->id }}"
                                                data-nom="{{ $user->nom }}"
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fas fa-users fa-2x d-block mb-2"></i>
                                    Aucun utilisateur trouvé
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- ============================================
         MODAL UTILISATEUR (Création / Modification)
    ============================================ --}}
    <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #0F3328, #1B4D3E); border-bottom: 2px solid #F5A623;">
                    <h5 class="modal-title text-white" id="userModalLabel">
                        <i class="fas fa-user me-2 text-tgf-accent"></i>
                        <span id="modal-title">Nouvel utilisateur</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form id="user-form" method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <input type="hidden" id="user_id" name="user_id">
                    <input type="hidden" name="_method" id="form-method" value="POST">

                    <div class="modal-body">
                        <div class="row g-3">
                            {{-- Nom --}}
                            <div class="col-md-6">
                                <label class="form-label-tgf" for="nom">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-tgf" id="nom" name="nom"
                                       placeholder="Nom complet" required>
                                <div class="invalid-feedback" id="error-nom"></div>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <label class="form-label-tgf" for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-tgf" id="email" name="email"
                                       placeholder="exemple@domaine.com" required>
                                <div class="invalid-feedback" id="error-email"></div>
                            </div>

                            {{-- Rôle --}}
                            <div class="col-md-6">
                                <label class="form-label-tgf" for="role_id">Rôle <span class="text-danger">*</span></label>
                                <select class="form-control form-control-tgf" id="role_id" name="role_id" required>
                                    <option value="">Sélectionner</option>
                                    @foreach($roles as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="error-role_id"></div>
                            </div>

                            {{-- Statut --}}
                            <div class="col-md-6">
                                <label class="form-label-tgf" for="est_actif">Statut</label>
                                <select class="form-control form-control-tgf" id="est_actif" name="est_actif">
                                    <option value="1">Actif</option>
                                    <option value="0">Inactif</option>
                                </select>
                            </div>

                            {{-- Mot de passe --}}
                            <div class="col-12" id="password-group">
                                <hr>
                                <h6 class="fw-600 text-tgf-primary">
                                    <i class="fas fa-lock me-2 text-tgf-accent"></i> Mot de passe
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label-tgf" for="mot_de_passe">
                                            Mot de passe <span class="text-danger" id="password-required">*</span>
                                        </label>
                                        <input type="password" class="form-control form-control-tgf" id="mot_de_passe"
                                               name="mot_de_passe" placeholder="••••••••" minlength="8">
                                        <div class="invalid-feedback" id="error-mot_de_passe"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-tgf" for="mot_de_passe_confirmation">
                                            Confirmation <span class="text-danger" id="password-confirm-required">*</span>
                                        </label>
                                        <input type="password" class="form-control form-control-tgf" id="mot_de_passe_confirmation"
                                               name="mot_de_passe_confirmation" placeholder="••••••••" minlength="8">
                                        <div class="invalid-feedback" id="error-mot_de_passe_confirmation"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                        <button type="submit" class="btn btn-tgf-primary" id="btn-submit">
                            <i class="fas fa-save"></i> <span id="btn-submit-text">Créer</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('css')
    <style>
        .avatar-circle {
            font-family: 'Manrope', sans-serif;
        }
        .btn-group-sm .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }
        .invalid-feedback {
            display: none;
            font-size: 0.8rem;
            color: #DC3545;
            margin-top: 4px;
        }
        .invalid-feedback.show {
            display: block;
        }
        .form-control.is-invalid {
            border-color: #DC3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {

            // ============================================
            // OUVERTURE MODAL - CRÉATION
            // ============================================
            $('#btn-new-user').on('click', function() {
                resetModal();
                $('#modal-title').text('Nouvel utilisateur');
                $('#btn-submit-text').text('Créer');
                $('#user-form').attr('action', '{{ route("users.store") }}');
                $('#form-method').val('POST');
                $('#user_id').val('');
                $('#password-required').show();
                $('#password-confirm-required').show();
                $('#mot_de_passe').prop('required', true);
                $('#mot_de_passe_confirmation').prop('required', true);
                $('#password-group').show();
                $('#user-form')[0].reset();
                $('#user-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#userModal').modal('show');
            });

            // ============================================
            // OUVERTURE MODAL - ÉDITION
            // ============================================
            $(document).on('click', '.btn-edit-user', function() {
                const id = $(this).data('id');
                const nom = $(this).data('nom');
                const email = $(this).data('email');
                const role = $(this).data('role');
                const statut = $(this).data('statut');

                resetModal();
                $('#modal-title').text('Modifier l\'utilisateur');
                $('#btn-submit-text').text('Mettre à jour');
                $('#user-form').attr('action', '/users/' + id);
                $('#form-method').val('PUT');
                $('#user_id').val(id);
                $('#nom').val(nom);
                $('#email').val(email);
                $('#role_id').val(role);
                $('#est_actif').val(statut);
                $('#password-required').hide();
                $('#password-confirm-required').hide();
                $('#mot_de_passe').prop('required', false);
                $('#mot_de_passe_confirmation').prop('required', false);
                $('#password-group').hide();
                $('#user-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#userModal').modal('show');
            });

            // ============================================
            // RESET MODAL
            // ============================================
            function resetModal() {
                $('#user-form')[0].reset();
                $('#user-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#user_id').val('');
                $('#form-method').val('POST');
            }

            // ============================================
            // SOUMISSION DU FORMULAIRE (AJAX)
            // ============================================
            $('#user-form').on('submit', function(e) {
                e.preventDefault();

                // Reset des erreurs
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();

                const form = $(this);
                const url = form.attr('action');
                const method = $('#form-method').val();
                const formData = form.serialize();

                const btn = $('#btn-submit');
                const originalText = btn.html();
                btn.html('<i class="fas fa-spinner fa-spin"></i> Chargement...').prop('disabled', true);

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        btn.html(originalText).prop('disabled', false);

                        if (response.success) {
                            // Recharger la page pour voir les modifications
                            toastr.success(response.message);
                            $('#userModal').modal('hide');
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        btn.html(originalText).prop('disabled', false);

                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let firstField = true;

                            Object.keys(errors).forEach(function(key) {
                                const field = $('#' + key);
                                const errorDiv = $('#error-' + key);
                                if (field.length) {
                                    field.addClass('is-invalid');
                                    errorDiv.text(errors[key][0]).addClass('show');
                                    if (firstField) {
                                        field.focus();
                                        firstField = false;
                                    }
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
            // CHANGEMENT DE STATUT (AJAX)
            // ============================================
            $(document).on('click', '.btn-toggle-status', function() {
                const id = $(this).data('id');
                const btn = $(this);
                const icon = btn.find('i');

                Swal.fire({
                    title: 'Confirmer',
                    text: 'Voulez-vous changer le statut de cet utilisateur ?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#F5A623',
                    cancelButtonColor: '#6B8A7E',
                    confirmButtonText: 'Oui, changer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        btn.prop('disabled', true);
                        icon.addClass('fa-spin');

                        $.ajax({
                            url: '/users/' + id + '/toggle-status',
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
                                } else {
                                    toastr.error(response.message);
                                    btn.prop('disabled', false);
                                    icon.removeClass('fa-spin');
                                }
                            },
                            error: function() {
                                toastr.error('Erreur lors de la mise à jour du statut.');
                                btn.prop('disabled', false);
                                icon.removeClass('fa-spin');
                            }
                        });
                    }
                });
            });

            // ============================================
            // SUPPRESSION (SweetAlert + AJAX)
            // ============================================
            $(document).on('click', '.btn-delete-user', function() {
                const id = $(this).data('id');
                const nom = $(this).data('nom');
                const btn = $(this);

                Swal.fire({
                    title: 'Confirmer la suppression',
                    html: `Voulez-vous vraiment supprimer <strong>${nom}</strong> ?<br><small class="text-muted">Cette action est irréversible.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DC3545',
                    cancelButtonColor: '#6B8A7E',
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        btn.prop('disabled', true);
                        btn.html('<i class="fas fa-spinner fa-spin"></i>');

                        $.ajax({
                            url: '/users/' + id,
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
                                } else {
                                    toastr.error(response.message);
                                    btn.prop('disabled', false);
                                    btn.html('<i class="fas fa-trash"></i>');
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

        });
    </script>
@endpush
