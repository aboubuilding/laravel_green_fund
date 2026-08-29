@extends('layouts.app')

@section('title', 'Gestion des médias')

@section('page_title', 'Gestion des médias')
@section('page_icon', 'fa-photo-video')

@section('breadcrumb')
    <li class="active">Médias</li>
@endsection

@section('page_actions')
    <button class="btn-tgf-primary btn-sm" id="btn-new-media">
        <i class="fas fa-plus"></i> Ajouter un média
    </button>
@endsection

@section('contenu')

    <div class="container-fluid px-0">

        {{-- Filtres --}}
        <div class="row g-3 mb-4">
            <div class="col-md-8">
                <div class="d-flex gap-2 flex-wrap">
                    <div class="btn-group">
                        <button class="btn btn-outline-secondary btn-sm filter-type active" data-value="">Tous</button>
                        @foreach($types as $value => $label)
                            <button class="btn btn-outline-secondary btn-sm filter-type" data-value="{{ $value }}">
                                <i class="fas {{ $value == TypeMedia::PHOTO ? 'fa-image' : 'fa-video' }}"></i>
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
                    <input type="text" class="form-control" id="search-media" placeholder="Rechercher un média...">
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
                            <p class="stat-label">Total médias</p>
                        </div>
                        <div class="stat-icon bg-tgf-primary-light">
                            <i class="fas fa-photo-video text-tgf-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #F5A623;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['photos'] }}</p>
                            <p class="stat-label">Photos</p>
                        </div>
                        <div class="stat-icon bg-tgf-accent-light">
                            <i class="fas fa-image text-tgf-accent"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #2E8B57;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['videos'] }}</p>
                            <p class="stat-label">Vidéos</p>
                        </div>
                        <div class="stat-icon" style="background: rgba(46, 139, 87, 0.1);">
                            <i class="fas fa-video text-tgf-success"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #6B46C1;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number">{{ $stats['recent'] }}</p>
                            <p class="stat-label">Récents (5 derniers)</p>
                        </div>
                        <div class="stat-icon" style="background: rgba(107, 70, 193, 0.1);">
                            <i class="fas fa-clock" style="color: #6B46C1;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grille --}}
        <div class="card-tgf">
            <div class="card-header">
                <i class="fas fa-th card-title-icon"></i>
                Galerie des médias
                <span class="badge bg-primary ms-2" id="media-count">{{ $media->count() }}</span>
            </div>
            <div class="card-body">
                <div class="row g-4" id="media-grid">
                    @include('media._grid', ['media' => $media])
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL MÉDIA --}}
    @include('media._modal')

@endsection

@push('css')
    <style>
        .media-card {
            transition: all 0.3s ease;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .media-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .media-card .media-thumb {
            height: 200px;
            background: #f0f5f2;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
        .media-card .media-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .media-card .media-thumb .placeholder-icon {
            font-size: 3rem;
            color: #8AA89A;
        }
        .media-card .media-thumb .media-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .media-card .media-body {
            padding: 15px;
        }
        .media-card .media-body .media-description {
            font-size: 0.9rem;
            color: var(--tgf-text-secondary);
            margin-bottom: 8px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .media-card .media-body .media-date {
            font-size: 0.75rem;
            color: var(--tgf-text-muted);
        }
        .media-card .media-actions {
            display: flex;
            gap: 4px;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {

            // ============================================
            // OUVERTURE MODAL - CRÉATION
            // ============================================
            $('#btn-new-media').on('click', function() {
                resetModal();
                $('#modal-title').text('Ajouter un média');
                $('#btn-submit-text').text('Ajouter');
                $('#form-method').val('POST');
                $('#media_id').val('');
                $('#media-form')[0].reset();
                $('#media-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#file-required').show();
                $('#fichier').prop('required', true);
                $('#mediaModal').modal('show');
            });

            // ============================================
            // OUVERTURE MODAL - ÉDITION
            // ============================================
            $(document).on('click', '.btn-edit-media', function() {
                const id = $(this).data('id');

                resetModal();
                $('#modal-title').text('Modifier le média');
                $('#btn-submit-text').text('Mettre à jour');
                $('#form-method').val('PUT');

                $.ajax({
                    url: '/media/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        $('#media_id').val(data.id);
                        $('#type_media').val(data.type_media);
                        $('#description').val(data.description);
                        $('#date').val(data.date);
                        $('#file-required').hide();
                        $('#fichier').prop('required', false);
                        $('#media-form .is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').removeClass('show').empty();
                        $('#mediaModal').modal('show');

                        // Afficher l'aperçu
                        if (data.miniature) {
                            $('#preview-container').show();
                            $('#preview-image').attr('src', '/storage/' + data.miniature);
                        } else {
                            $('#preview-container').hide();
                        }
                    },
                    error: function() {
                        toastr.error('Erreur lors du chargement des données.');
                    }
                });
            });

            // ============================================
            // SOUMISSION DU FORMULAIRE (AJAX)
            // ============================================
            $('#media-form').on('submit', function(e) {
                e.preventDefault();

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();

                const form = $(this);
                const formData = new FormData(this);
                const id = $('#media_id').val();
                const url = id ? '/media/' + id : '/media';

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
                            $('#mediaModal').modal('hide');
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
            // SUPPRESSION (SweetAlert + AJAX)
            // ============================================
            $(document).on('click', '.btn-delete-media', function() {
                const id = $(this).data('id');
                const description = $(this).data('description');
                const btn = $(this);

                Swal.fire({
                    title: 'Confirmer la suppression',
                    html: `Voulez-vous vraiment supprimer ce média ?<br><small class="text-muted">"${description || 'Sans description'}"</small><br><small class="text-muted">Cette action est irréversible.</small>`,
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
                            url: '/media/' + id,
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
                const type = $('.filter-type.active').data('value') || '';

                $.ajax({
                    url: '/media/filter',
                    method: 'GET',
                    data: { type: type },
                    success: function(response) {
                        if (response.success) {
                            $('#media-grid').html(response.html);
                            $('#media-count').text(response.count);
                        }
                    }
                });
            }

            $('.filter-type').on('click', function() {
                $('.filter-type').removeClass('active');
                $(this).addClass('active');
                applyFilters();
            });

            $('#btn-reset-filters').on('click', function() {
                $('.filter-type').removeClass('active');
                $('.filter-type[data-value=""]').addClass('active');
                $('#search-media').val('');
                applyFilters();
            });

            // ============================================
            // RECHERCHE
            // ============================================
            $('#btn-search').on('click', function() {
                const query = $('#search-media').val();

                if (!query) {
                    applyFilters();
                    return;
                }

                $.ajax({
                    url: '/media/search',
                    method: 'GET',
                    data: { q: query },
                    success: function(response) {
                        if (response.success) {
                            $('#media-grid').html(response.html);
                            $('#media-count').text(response.count);
                        }
                    }
                });
            });

            $('#search-media').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btn-search').click();
                }
            });

            // ============================================
            // APERÇU DU FICHIER
            // ============================================
            $('#fichier').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-container').show();
                        $('#preview-image').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // ============================================
            // RESET MODAL
            // ============================================
            function resetModal() {
                $('#media-form')[0].reset();
                $('#media-form .is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').removeClass('show').empty();
                $('#media_id').val('');
                $('#form-method').val('POST');
                $('#preview-container').hide();
                $('#preview-image').attr('src', '');
            }

        });
    </script>
@endpush
