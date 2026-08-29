@forelse($infos as $info)
    <tr>
        <td>
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-info-circle text-tgf-primary"></i>
                <strong>{{ $info->titre }}</strong>
            </div>
        </td>
        <td>
            @if($info->contenu)
                {{ $info->contenu_court }}
            @else
                <span class="text-muted">-</span>
            @endif
        </td>
        <td>{{ $info->date_formatee }}</td>
        <td>
            <span class="badge badge-tgf-{{ $info->statut_badge }}">
                <i class="fas fa-{{ $info->isActif() ? 'eye' : 'eye-slash' }}"></i>
                {{ $info->statut_label }}
            </span>
        </td>
        <td>
            <div class="d-flex justify-content-center gap-1">
                <button class="btn btn-sm btn-{{ $info->isActif() ? 'warning' : 'success' }} btn-toggle-status"
                        data-id="{{ $info->id }}"
                        data-active="{{ $info->isActif() ? 1 : 0 }}"
                        title="{{ $info->isActif() ? 'Désactiver' : 'Activer' }}">
                    <i class="fas fa-{{ $info->isActif() ? 'eye-slash' : 'eye' }}"></i>
                </button>
                <button class="btn btn-sm btn-primary btn-edit-info" data-id="{{ $info->id }}" title="Modifier">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-delete-info"
                        data-id="{{ $info->id }}"
                        data-titre="{{ $info->titre }}"
                        title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center py-4 text-muted">
            <i class="fas fa-info-circle fa-2x d-block mb-2"></i>
            Aucune info trouvée
        </td>
    </tr>
@endforelse
