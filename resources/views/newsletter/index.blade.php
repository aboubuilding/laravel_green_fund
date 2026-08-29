@extends('layouts.app')

@section('title', 'Gestion de la newsletter')

@section('page_title', 'Gestion de la newsletter')
@section('page_icon', 'fa-envelope-open-text')

@section('breadcrumb')
    <li class="active">Newsletter</li>
@endsection

@section('page_actions')
    <button class="btn-tgf-primary btn-sm" id="btn-new-newsletter">
        <i class="fas fa-plus"></i> Ajouter un abonné
    </button>
    <button class="btn-tgf-accent btn-sm" id="btn-send-campaign">
        <i class="fas fa-paper-plane"></i> Envoyer une campagne
    </button>
    <a href="{{ route('newsletter.export') }}" class="btn-tgf-outline-primary btn-sm">
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
                                <i class="fas {{ $value == 'actif' ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
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
                    <input type="text" class="form-control" id="search-newsletter" placeholder="Rechercher un email...">
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
                            <p class="stat-label">Total abonnés</p>
                        </div>
                        <div class="stat-icon bg-tgf-primary-light">
                            <i class="fas fa-users text-tgf-primary"></i>
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
                            <p class="stat-number">{{ $stats['desabonnes'] }}</p>
                            <p class="stat-label">Désabonnés</p>
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
                Liste des abonnés
                <span class="badge bg-primary ms-2" id="newsletter-count">{{ $newsletters->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-tgf mb-0">
                        <thead>
                        <tr>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Date d'inscription</th>
                            <th>Date de création</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="newsletter-table-body">
                        @include('newsletter._rows', ['newsletters' => $newsletters])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL AJOUT ABONNÉ --}}
    @include('newsletter._modal')

    {{-- MODAL ENVOI CAMPAGNE --}}
    @include('newsletter._campaign')

@endsection

@push('js')
    <script>
        $(document).ready(function() {

            // ============================================
            // OUVERTURE MODAL - AJOUT ABONNÉ
            // ============================================
            $('#btn-new-newsletter').on('click', function() {
                resetModal();
                $('#modal-title').text('Ajouter un abonné');
                $('#btn-submit-text').text('Ajouter');
                $('#newsletter_id').val('');
                $('#newsletter-form')[0].reset();
                $('#newsletter-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#newsletterModal').modal('show');
            });

            // ============================================
            // OUVERTURE MODAL - ENVOI CAMPAGNE
            // ============================================
            $('#btn-send-campaign').on('click', function() {
                $('#campaign-form')[0].reset();
                $('#campaign-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#campaignModal').modal('show');
            });

            // ============================================
            // SOUMISSION FORMULAIRE ABONNÉ (AJAX)
            // ============================================
            $('#newsletter-form').on('submit', function(e) {
                e.preventDefault();

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();

                const form = $(this);
                const formData = form.serialize();
                const id = $('#newsletter_id').val();
                const url = id ? '/newsletter/' + id : '/newsletter';

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
                            $('#newsletterModal').modal('hide');
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
            // SOUMISSION FORMULAIRE CAMPAGNE (AJAX)
            // ============================================
            $('#campaign-form').on('submit', function(e) {
                e.preventDefault();

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();

                const form = $(this);
                const formData = form.serialize();

                const btn = $('#btn-send');
                const originalText = btn.html();
                btn.html('<i class="fas fa-spinner fa-spin"></i> Envoi en cours...').prop('disabled', true);

                $.ajax({
                    url: '{{ route("newsletter.send") }}',
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
                            $('#campaignModal').modal('hide');
                        } else {
                            toastr.error(response.message);
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
            // DÉSABONNER / RÉINSCRIRE
            // ============================================
            $(document).on('click', '.btn-unsubscribe', function() {
                const id = $(this).data('id');
                const isDesabonne = $(this).data('desabonne') === 1;
                const btn = $(this);

                const title = isDesabonne ? 'Réinscrire' : 'Désabonner';
                const text = isDesabonne ? 'Cet abonné sera de nouveau actif.' : 'Cet abonné ne recevra plus vos emails.';

                Swal.fire({
                    title: 'Confirmer',
                    html: `<strong>${title}</strong><br><small class="text-muted">${text}</small>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: isDesabonne ? '#2E8B57' : '#DC3545',
                    cancelButtonColor: '#6B8A7E',
                    confirmButtonText: isDesabonne ? 'Oui, réinscrire' : 'Oui, désabonner',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const url = isDesabonne ? '/newsletter/' + id + '/resubscribe' : '/newsletter/' + id + '/unsubscribe';

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
                                btn.html(isDesabonne ? '<i class="fas fa-undo"></i>' : '<i class="fas fa-user-slash"></i>');
                            }
                        });
                    }
                });
            });

            // ============================================
            // SUPPRESSION (SweetAlert + AJAX)
            // ============================================
            $(document).on('click', '.btn-delete-newsletter', function() {
                const id = $(this).data('id');
                const email = $(this).data('email');
                const btn = $(this);

                Swal.fire({
                    title: 'Confirmer la suppression',
                    html: `Voulez-vous vraiment supprimer <strong>${email}</strong> ?<br><small class="text-muted">Cette action est irréversible.</small>`,
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
                            url: '/newsletter/' + id,
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
                    url: '/newsletter/filter',
                    method: 'GET',
                    data: { statut: statut },
                    success: function(response) {
                        if (response.success) {
                            $('#newsletter-table-body').html(response.html);
                            $('#newsletter-count').text(response.count);
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
                $('#search-newsletter').val('');
                applyFilters();
            });

            // ============================================
            // RECHERCHE
            // ============================================
            $('#btn-search').on('click', function() {
                const query = $('#search-newsletter').val();

                if (!query) {
                    applyFilters();
                    return;
                }

                $.ajax({
                    url: '/newsletter/search',
                    method: 'GET',
                    data: { q: query },
                    success: function(response) {
                        if (response.success) {
                            $('#newsletter-table-body').html(response.html);
                            $('#newsletter-count').text(response.count);
                        }
                    }
                });
            });

            $('#search-newsletter').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btn-search').click();
                }
            });

            // ============================================
            // RESET MODAL
            // ============================================
            function resetModal() {
                $('#newsletter-form')[0].reset();
                $('#newsletter-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#newsletter_id').val('');
            }

        });
    </script>
@endpush
