@forelse($griefs as $grief)
    <tr>
        <td>{{ $grief->id }}</td>
        <td>
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-user text-tgf-primary"></i>
                <strong>{{ $grief->nom }}</strong>
            </div>
        </td>
        <td>
            @if($grief->email)
                <div><small>{{ $grief->email }}</small></div>
            @endif
            @if($grief->telephone)
                <div><small>{{ $grief->telephone }}</small></div>
            @endif
        </td>
        <td>{{ $grief->nom_projet }}</td>
        <td>
            <span title="{{ $grief->description }}">
                {{ Str::limit($grief->description, 50) }}
            </span>
        </td>
        <td>
            <span class="badge badge-tgf-{{ $grief->statut_badge }}">
                <i class="fas {{ $grief->statut_icon }}"></i>
                {{ $grief->statut_label }}
            </span>
        </td>
        <td>
            <small>{{ $grief->temps_ecoule }}</small>
        </td>
        <td>
            <div class="d-flex justify-content-center gap-1 flex-wrap">
                <button class="btn btn-sm btn-info btn-show-grief" data-id="{{ $grief->id }}" title="Consulter">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-sm btn-primary btn-edit-grief" data-id="{{ $grief->id }}" title="Modifier">
                    <i class="fas fa-edit"></i>
                </button>
                @if(!$grief->isResolu())
                    <button class="btn btn-sm btn-success btn-repondre-grief" data-id="{{ $grief->id }}" title="Répondre">
                        <i class="fas fa-reply"></i>
                    </button>
                @endif
                @if($grief->isNouveau())
                    <button class="btn btn-sm btn-warning btn-changer-statut"
                            data-id="{{ $grief->id }}"
                            data-statut="en_cours"
                            data-label="En cours"
                            title="Mettre en cours">
                        <i class="fas fa-play"></i>
                    </button>
                @endif
                @if($grief->isEnCours())
                    <button class="btn btn-sm btn-success btn-cloturer-grief" data-id="{{ $grief->id }}" title="Clôturer">
                        <i class="fas fa-check"></i>
                    </button>
                @endif
                <button class="btn btn-sm btn-danger btn-delete-grief"
                        data-id="{{ $grief->id }}"
                        data-nom="{{ $grief->nom }}"
                        title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center py-4 text-muted">
            <i class="fas fa-exclamation-triangle fa-2x d-block mb-2"></i>
            Aucun grief trouvé
        </td>
    </tr>
@endforelse
