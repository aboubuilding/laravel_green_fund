@forelse($facilites as $facilite)
    <tr>
        <td>
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-hand-holding-heart text-tgf-accent"></i>
                <strong>{{ $facilite->nom }}</strong>
            </div>
        </td>
        <td>
            @if($facilite->description)
                {{ Str::limit($facilite->description, 60) }}
            @else
                <span class="text-muted">-</span>
            @endif
        </td>
        <td>
            <span class="badge bg-primary">{{ $facilite->nb_projets }}</span>
        </td>
        <td>
            <span class="badge badge-tgf-{{ $facilite->statut_badge }}">
                <i class="fas fa-{{ $facilite->isActif() ? 'eye' : 'eye-slash' }}"></i>
                {{ $facilite->statut_label }}
            </span>
        </td>
        <td>
            <div class="d-flex justify-content-center gap-1 flex-wrap">
                <button class="btn btn-sm btn-info btn-chiffres" data-id="{{ $facilite->id }}" title="Chiffres clés">
                    <i class="fas fa-chart-simple"></i>
                </button>
                <button class="btn btn-sm btn-secondary btn-projets" data-id="{{ $facilite->id }}" title="Projets">
                    <i class="fas fa-project-diagram"></i>
                </button>
                <button class="btn btn-sm btn-primary btn-edit-facilite" data-id="{{ $facilite->id }}" title="Modifier">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-delete-facilite"
                        data-id="{{ $facilite->id }}"
                        data-nom="{{ $facilite->nom }}"
                        title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center py-4 text-muted">
            <i class="fas fa-hand-holding-heart fa-2x d-block mb-2"></i>
            Aucune facilité trouvée
        </td>
    </tr>
@endforelse
