@forelse($guichets as $guichet)
    <tr>
        <td>
            <div class="d-flex align-items-center gap-2">
                <i class="{{ $guichet->icone ?? 'fas fa-folder' }} text-tgf-accent"></i>
                <strong>{{ $guichet->nom }}</strong>
            </div>
        </td>
        <td>
            <span class="badge bg-light text-dark">
                <i class="{{ $guichet->icone ?? 'fas fa-folder' }}"></i>
            </span>
        </td>
        <td>
            @if($guichet->description)
                {{ Str::limit($guichet->description, 60) }}
            @else
                <span class="text-muted">-</span>
            @endif
        </td>
        <td>
            <span class="badge bg-primary">{{ $guichet->nb_projets }}</span>
        </td>
        <td>
            <span class="badge badge-tgf-{{ $guichet->statut_badge }}">
                <i class="fas fa-{{ $guichet->isActif() ? 'eye' : 'eye-slash' }}"></i>
                {{ $guichet->statut_label }}
            </span>
        </td>
        <td>
            <div class="d-flex justify-content-center gap-1 flex-wrap">
                <button class="btn btn-sm btn-info btn-chiffres" data-id="{{ $guichet->id }}" title="Chiffres clés">
                    <i class="fas fa-chart-simple"></i>
                </button>
                <button class="btn btn-sm btn-secondary btn-projets" data-id="{{ $guichet->id }}" title="Projets">
                    <i class="fas fa-project-diagram"></i>
                </button>
                <button class="btn btn-sm btn-primary btn-edit-guichet" data-id="{{ $guichet->id }}" title="Modifier">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-delete-guichet"
                        data-id="{{ $guichet->id }}"
                        data-nom="{{ $guichet->nom }}"
                        title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center py-4 text-muted">
            <i class="fas fa-store fa-2x d-block mb-2"></i>
            Aucun guichet trouvé
        </td>
    </tr>
@endforelse
