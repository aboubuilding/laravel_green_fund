@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('page_title', 'Tableau de bord')
@section('page_icon', 'fa-gauge-high')

@section('breadcrumb')
    <li class="active">Tableau de bord</li>
@endsection

@section('page_actions')
    <a href="#" class="btn-tgf-outline-primary btn-sm">
        <i class="fas fa-file-export"></i> Exporter
    </a>
    <a href="#" class="btn-tgf-primary btn-sm">
        <i class="fas fa-plus"></i> Nouveau projet
    </a>
@endsection

@section('contenu')

    <div class="container-fluid px-0">

        {{-- ============================================
             SECTION BIENVENUE
        ============================================ --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card-tgf bg-tgf-primary text-white p-4 rounded-tgf-lg" style="background: linear-gradient(135deg, #0F3328, #1B4D3E);">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 class="fw-700 mb-1" style="font-family: 'Manrope', sans-serif;">
                                <i class="fas fa-leaf me-2 text-tgf-accent"></i>
                                Bonjour, {{ $user->nom ?? 'Utilisateur' }} 👋
                            </h4>
                            <p class="text-white-50 mb-0" style="font-family: 'Manrope', sans-serif;">
                                Bienvenue sur votre tableau de bord TogoGreenFund
                            </p>
                        </div>
                        <div class="text-end">
                            <small class="text-white-50" style="font-family: 'Manrope', sans-serif;">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ Carbon\Carbon::now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================
             STATISTIQUES
        ============================================ --}}
        <div class="row g-4 mb-4">
            <div class="col-md-4 col-sm-6">
                <div class="stat-card-tgf">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number" style="font-family: 'Manrope', sans-serif;">{{ number_format($stats['fcfas_mobilises'], 0, ',', ' ') }}</p>
                            <p class="stat-label" style="font-family: 'Manrope', sans-serif;">FCFA mobilisés</p>
                        </div>
                        <div class="stat-icon bg-tgf-primary-light">
                            <i class="fas fa-money-bill-wave text-tgf-primary"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                    <span class="stat-trend text-success" style="font-family: 'Manrope', sans-serif;">
                        <i class="fas fa-arrow-up"></i> +{{ $stats['croissance_fcfas'] }}%
                    </span>
                        <span class="text-muted ms-2" style="font-size:0.7rem; font-family: 'Manrope', sans-serif;">vs mois dernier</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #F5A623;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number" style="font-family: 'Manrope', sans-serif;">{{ $stats['projets_finances'] }}</p>
                            <p class="stat-label" style="font-family: 'Manrope', sans-serif;">Projets financés</p>
                        </div>
                        <div class="stat-icon bg-tgf-accent-light">
                            <i class="fas fa-project-diagram text-tgf-accent"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                    <span class="stat-trend text-success" style="font-family: 'Manrope', sans-serif;">
                        <i class="fas fa-arrow-up"></i> +{{ $stats['croissance_projets'] }}%
                    </span>
                        <span class="text-muted ms-2" style="font-size:0.7rem; font-family: 'Manrope', sans-serif;">vs mois dernier</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="stat-card-tgf" style="border-left-color: #2E8B57;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stat-number" style="font-family: 'Manrope', sans-serif;">{{ number_format($stats['beneficiaires'], 0, ',', ' ') }}</p>
                            <p class="stat-label" style="font-family: 'Manrope', sans-serif;">Bénéficiaires</p>
                        </div>
                        <div class="stat-icon bg-tgf-success" style="background: rgba(46, 139, 87, 0.1);">
                            <i class="fas fa-users text-tgf-success"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                    <span class="stat-trend text-success" style="font-family: 'Manrope', sans-serif;">
                        <i class="fas fa-arrow-up"></i> +{{ $stats['croissance_beneficiaires'] }}%
                    </span>
                        <span class="text-muted ms-2" style="font-size:0.7rem; font-family: 'Manrope', sans-serif;">vs mois dernier</span>
                    </div>
                </div>
            </div>


        </div>

        {{-- ============================================
             SOUMISSIONS & GRIEFS
        ============================================ --}}
        <div class="row g-4 mb-4">
            {{-- Soumissions en attente --}}
            <div class="col-md-6">
                <div class="card-tgf">
                    <div class="card-header" style="font-family: 'Manrope', sans-serif;">
                        <i class="fas fa-clock card-title-icon"></i>
                        Soumissions en attente
                        <span class="badge bg-warning ms-2">{{ count($soumissions) }}</span>
                    </div>
                    <div class="card-body p-0">
                        @foreach($soumissions as $soumission)
                            <div class="p-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1 fw-600" style="font-family: 'Manrope', sans-serif;">{{ $soumission['projet'] }}</h6>
                                        <p class="text-muted small mb-1" style="font-family: 'Manrope', sans-serif;">
                                            <i class="fas fa-user"></i> {{ $soumission['porteur'] }}
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-money-bill"></i>
                                            {{ number_format($soumission['montant'], 0, ',', ' ') }} FCFA
                                        </p>
                                        <span class="badge badge-tgf-{{ $soumission['priorite'] === 'haute' ? 'danger' : ($soumission['priorite'] === 'moyenne' ? 'warning' : 'secondary') }}" style="font-family: 'Manrope', sans-serif;">
                                        {{ ucfirst($soumission['priorite']) }}
                                    </span>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted d-block" style="font-family: 'Manrope', sans-serif;">{{ $soumission['depose_le']->diffForHumans() }}</small>
                                        <span class="badge bg-info" style="font-family: 'Manrope', sans-serif;">En attente</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if(count($soumissions) == 0)
                            <div class="p-4 text-center text-muted" style="font-family: 'Manrope', sans-serif;">
                                <i class="fas fa-check-circle fa-2x text-success mb-2 d-block"></i>
                                Aucune soumission en attente
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Griefs/Plaintes --}}
            <div class="col-md-6">
                <div class="card-tgf">
                    <div class="card-header" style="font-family: 'Manrope', sans-serif;">
                        <i class="fas fa-exclamation-triangle card-title-icon" style="color: var(--tgf-danger);"></i>
                        Griefs/Plaintes non traités
                        <span class="badge bg-danger ms-2">{{ count($griefs) }}</span>
                    </div>
                    <div class="card-body p-0">
                        @foreach($griefs as $grief)
                            <div class="p-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1 fw-600" style="font-family: 'Manrope', sans-serif;">
                                        <span class="badge bg-{{ $grief['type'] === 'plainte' ? 'danger' : 'warning' }} me-1" style="font-family: 'Manrope', sans-serif;">
                                            {{ ucfirst($grief['type']) }}
                                        </span>
                                            {{ $grief['sujet'] }}
                                        </h6>
                                        <p class="text-muted small mb-1" style="font-family: 'Manrope', sans-serif;">
                                            <i class="fas fa-user"></i> {{ $grief['auteur'] }}
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-project-diagram"></i> {{ $grief['projet'] }}
                                        </p>
                                        <span class="badge badge-tgf-{{ $grief['priorite'] === 'haute' ? 'danger' : ($grief['priorite'] === 'moyenne' ? 'warning' : 'secondary') }}" style="font-family: 'Manrope', sans-serif;">
                                        {{ ucfirst($grief['priorite']) }}
                                    </span>
                                        <span class="badge badge-tgf-{{ $grief['statut'] === 'nouveau' ? 'primary' : 'warning' }}" style="font-family: 'Manrope', sans-serif;">
                                        {{ ucfirst($grief['statut']) }}
                                    </span>
                                    </div>
                                    <small class="text-muted" style="font-family: 'Manrope', sans-serif;">{{ $grief['reçu_le']->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                        @if(count($griefs) == 0)
                            <div class="p-4 text-center text-muted" style="font-family: 'Manrope', sans-serif;">
                                <i class="fas fa-check-circle fa-2x text-success mb-2 d-block"></i>
                                Aucun grief/plainte en attente
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================
             ACTUALITÉS
        ============================================ --}}
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card-tgf">
                    <div class="card-header" style="font-family: 'Manrope', sans-serif;">
                        <i class="fas fa-newspaper card-title-icon"></i>
                        Dernières actualités
                        <span class="badge bg-primary ms-2">{{ count($actualites) }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach($actualites as $actualite)
                                <div class="col-md-4">
                                    <div class="p-3 bg-light rounded-tgf h-100">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="fw-600 mb-0" style="font-family: 'Manrope', sans-serif;">{{ $actualite['titre'] }}</h6>
                                            @if($actualite['est_urgent'])
                                                <span class="badge bg-danger" style="font-family: 'Manrope', sans-serif;">Urgent</span>
                                            @endif
                                        </div>
                                        <p class="text-muted small mb-2" style="font-family: 'Manrope', sans-serif;">
                                            {{ Str::limit($actualite['contenu'], 80) }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge badge-tgf-primary" style="font-family: 'Manrope', sans-serif;">{{ $actualite['categorie'] }}</span>
                                            <small class="text-muted" style="font-family: 'Manrope', sans-serif;">{{ $actualite['publie_le']->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================
             PROJETS RÉCENTS
        ============================================ --}}
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card-tgf">
                    <div class="card-header" style="font-family: 'Manrope', sans-serif;">
                        <i class="fas fa-plus-circle card-title-icon"></i>
                        Derniers projets ajoutés
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-tgf mb-0">
                                <thead>
                                <tr>
                                    <th style="font-family: 'Manrope', sans-serif;">Projet</th>
                                    <th style="font-family: 'Manrope', sans-serif;">Porteur</th>
                                    <th style="font-family: 'Manrope', sans-serif;">Montant</th>
                                    <th style="font-family: 'Manrope', sans-serif;">Progression</th>
                                    <th style="font-family: 'Manrope', sans-serif;">Statut</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($projets as $projet)
                                    <tr>
                                        <td>
                                            <strong style="font-family: 'Manrope', sans-serif;">{{ $projet['titre'] }}</strong>
                                            <br>
                                            <small class="text-muted" style="font-family: 'Manrope', sans-serif;">{{ $projet['categorie'] }}</small>
                                        </td>
                                        <td style="font-family: 'Manrope', sans-serif;">
                                            {{ $projet['porteur'] }}
                                            <br>
                                            <small class="text-muted" style="font-family: 'Manrope', sans-serif;">{{ $projet['organisation'] }}</small>
                                        </td>
                                        <td style="font-family: 'Manrope', sans-serif;">
                                            {{ number_format($projet['montant_global'], 0, ',', ' ') }} FCFA
                                            <br>
                                            <small class="text-muted" style="font-family: 'Manrope', sans-serif;">
                                                Collecté: {{ number_format($projet['montant_collecte'], 0, ',', ' ') }} FCFA
                                            </small>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress" style="width: 100px; height: 8px;">
                                                    <div class="progress-bar bg-{{ $projet['taux_realisation'] >= 100 ? 'success' : ($projet['taux_realisation'] >= 70 ? 'primary' : ($projet['taux_realisation'] >= 40 ? 'warning' : 'danger')) }}"
                                                         role="progressbar"
                                                         style="width: {{ $projet['taux_realisation'] }}%">
                                                    </div>
                                                </div>
                                                <small style="font-family: 'Manrope', sans-serif;">{{ $projet['taux_realisation'] }}%</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $projet['statut'] === 'termine' ? 'success' : 'primary' }}" style="font-family: 'Manrope', sans-serif;">
                                                {{ ucfirst($projet['statut']) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================
             ÉVÉNEMENTS & NOTIFICATIONS
        ============================================ --}}
        <div class="row g-4">
            {{-- Événements à venir --}}
            <div class="col-md-6">
                <div class="card-tgf">
                    <div class="card-header" style="font-family: 'Manrope', sans-serif;">
                        <i class="fas fa-calendar-alt card-title-icon"></i>
                        Événements à venir
                    </div>
                    <div class="card-body p-0">
                        @foreach($evenements as $evenement)
                            <div class="p-3 border-bottom">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="text-center" style="min-width: 50px;">
                                        <div class="fw-700 text-tgf-primary" style="font-size: 1.2rem; font-family: 'Manrope', sans-serif;">
                                            {{ $evenement['date']->format('d') }}
                                        </div>
                                        <div class="text-muted small text-uppercase" style="font-family: 'Manrope', sans-serif;">
                                            {{ $evenement['date']->locale('fr')->isoFormat('MMM') }}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-600 mb-0" style="font-family: 'Manrope', sans-serif;">{{ $evenement['titre'] }}</h6>
                                        <p class="text-muted small mb-0" style="font-family: 'Manrope', sans-serif;">
                                            <i class="fas fa-clock"></i> {{ $evenement['heure'] }}
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-map-marker-alt"></i> {{ $evenement['lieu'] }}
                                        </p>
                                    </div>
                                    <span class="badge badge-tgf-primary text-uppercase" style="font-size: 0.6rem; font-family: 'Manrope', sans-serif;">
                                    {{ $evenement['type'] }}
                                </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Notifications --}}
            <div class="col-md-6">
                <div class="card-tgf">
                    <div class="card-header" style="font-family: 'Manrope', sans-serif;">
                        <i class="fas fa-bell card-title-icon"></i>
                        Notifications récentes
                        <span class="badge bg-danger ms-2" style="font-family: 'Manrope', sans-serif;">
                        {{ count(array_filter($notifications, fn($n) => !$n['lue'])) }}
                    </span>
                    </div>
                    <div class="card-body p-0">
                        @foreach($notifications as $notification)
                            <div class="p-3 border-bottom {{ !$notification['lue'] ? 'bg-tgf-primary-light' : '' }}">
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="text-{{ $notification['type'] === 'success' ? 'success' : ($notification['type'] === 'warning' ? 'warning' : ($notification['type'] === 'danger' ? 'danger' : 'primary')) }}">
                                        <i class="fas fa-{{ $notification['type'] === 'success' ? 'check-circle' : ($notification['type'] === 'warning' ? 'exclamation-triangle' : ($notification['type'] === 'danger' ? 'times-circle' : 'info-circle')) }}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-0 small" style="font-family: 'Manrope', sans-serif;">{{ $notification['message'] }}</p>
                                        <small class="text-muted" style="font-family: 'Manrope', sans-serif;">{{ $notification['date']->diffForHumans() }}</small>
                                    </div>
                                    @if(!$notification['lue'])
                                        <span class="badge bg-primary pulse-dot" style="font-family: 'Manrope', sans-serif;">Nouveau</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================
             ACTIVITÉS RÉCENTES
        ============================================ --}}
        <div class="row g-4 mt-2">
            <div class="col-12">
                <div class="card-tgf">
                    <div class="card-header" style="font-family: 'Manrope', sans-serif;">
                        <i class="fas fa-history card-title-icon"></i>
                        Activités récentes
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach($activites as $activite)
                                <div class="list-group-item d-flex align-items-center gap-3 border-0 border-bottom">
                                    <div class="stat-icon" style="width: 36px; height: 36px; background: rgba(27, 77, 62, 0.08); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--tgf-primary);">
                                        <i class="fas fa-{{ $activite['type'] === 'investissement' ? 'hand-holding-usd' : ($activite['type'] === 'projet' ? 'plus-circle' : ($activite['type'] === 'inscription' ? 'user-plus' : 'exclamation-triangle')) }}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-0 small" style="font-family: 'Manrope', sans-serif;">
                                            <strong style="font-family: 'Manrope', sans-serif;">{{ $activite['utilisateur'] }}</strong>
                                            {{ $activite['action'] }}
                                            @if($activite['projet'])
                                                <strong style="font-family: 'Manrope', sans-serif;">{{ $activite['projet'] }}</strong>
                                            @endif
                                        </p>
                                        <small class="text-muted" style="font-family: 'Manrope', sans-serif;">{{ $activite['date']->diffForHumans() }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('css')
    <style>
        /* Styles supplémentaires pour le dashboard */
        .badge-tgf-primary {
            background: rgba(27, 77, 62, 0.1);
            color: var(--tgf-primary);
            font-family: 'Manrope', sans-serif;
        }
        .badge-tgf-danger {
            background: rgba(220, 53, 69, 0.1);
            color: var(--tgf-danger);
            font-family: 'Manrope', sans-serif;
        }
        .badge-tgf-warning {
            background: rgba(245, 166, 35, 0.1);
            color: var(--tgf-accent-dark);
            font-family: 'Manrope', sans-serif;
        }
        .badge-tgf-secondary {
            background: rgba(107, 138, 126, 0.1);
            color: var(--tgf-muted);
            font-family: 'Manrope', sans-serif;
        }
        .pulse-dot {
            animation: pulse-dot 2s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        /* Manrope pour les statistiques */
        .stat-card-tgf .stat-number {
            font-family: 'Manrope', sans-serif;
            font-weight: 800;
        }
        .stat-card-tgf .stat-label {
            font-family: 'Manrope', sans-serif;
            font-weight: 500;
        }
        .stat-card-tgf .stat-trend {
            font-family: 'Manrope', sans-serif;
            font-weight: 600;
        }

        /* Manrope pour les cards */
        .card-tgf .card-header {
            font-family: 'Manrope', sans-serif;
            font-weight: 600;
        }

        /* Manrope pour les badges */
        .badge {
            font-family: 'Manrope', sans-serif;
        }

        /* Manrope pour les tables */
        .table-tgf {
            font-family: 'Manrope', sans-serif;
        }
        .table-tgf thead th {
            font-family: 'Manrope', sans-serif;
            font-weight: 600;
        }
        .table-tgf tbody td {
            font-family: 'Manrope', sans-serif;
        }
    </style>
@endpush
