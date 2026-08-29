@forelse($plaintes as $plainte)
    <tr>
        <td>{{ $plainte->id }}</td>
        <td>
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-user text-tgf-primary"></i>
                <strong>{{ $plainte->nom }}</strong>
            </div>
        </td>
        <td>
            @if($plainte->email)
                <div><small>{{ $plainte->email }}</small></div>
            @endif
            @if($plainte->telephone)
                <div><small>{{ $plainte->telephone }}</small></div>
            @endif
        </td>
        <td>
            <span title="{{ $plainte->description }}">
                {{ Str::limit($plainte->objet, 40) }}
            </span>
        </td>
        <td>
            <span class="badge badge-tgf-{{ $plainte->statut_badge }}">
                <i class="fas {{ $plainte->statut_icon }}"></i>
                {{ $plainte->statut_label }}
            </span>
        </td>
        <td>
            <small>{{ $plainte->temps_ecoule }}</small>
        </td>
        <td>
            <div class="d-flex justify-content-center gap-1 flex-wrap">
                <button class="btn btn-sm btn-info btn-show-plainte" data-id="{{ $plainte->id }}" title="Consulter">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-sm btn-primary btn-edit-plainte" data-id="{{ $plainte->id }}" title="Modifier">
                    <i class="fas fa-edit"></i>
                </button>
                @if(!$plainte->isResolue())
                    <button class="btn btn-sm btn-success btn-repondre-plainte" data-id="{{ $plainte->id }}" title="Répondre">
                        <i class="fas fa-reply"></i>
                    </button>
                @endif
                @if($plainte->isNouvelle())
                    <button class="btn btn-sm btn-warning btn-changer-statut"
                            data-id="{{ $plainte->id }}"
                            data-statut="en_cours"
                            data-label="En cours"
                            title="Mettre en cours">
                        <i class="fas fa-play"></i>
                    </button>
                @endif
                @if($plainte->isEnCours())
                    <button class="btn btn-sm btn-success btn-cloturer-plainte" data-id="{{ $plainte->id }}" title="Clôturer">
                        <i class="fas fa-check"></i>
                    </button>
                @endif
                <button class="btn btn-sm btn-danger btn-delete-plainte"
                        data-id="{{ $plainte->id }}"
                        data-nom="{{ $plainte->nom }}"
                        title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center py-4 text-muted">
            <i class="fas fa-file-signature fa-2x d-block mb-2"></i>
            Aucune plainte trouvée
        </td>
    </tr>
@endforelse
