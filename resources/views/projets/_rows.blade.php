@forelse($projets as $projet)
    <tr>
        <td>
            @if($projet->image)
                <img src="{{ $projet->image_url }}" alt="{{ $projet->titre }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
            @else
                <div style="width: 50px; height: 50px; border-radius: 8px; background: #f0f5f2; display: flex; align-items: center; justify-content: center; color: #8AA89A;">
                    <i class="fas fa-image"></i>
                </div>
            @endif
        </td>
        <td>
            <div>
                <strong>{{ $projet->titre }}</strong>
                <br>
                <small class="text-muted">{{ Str::limit($projet->description, 50) }}</small>
            </div>
        </td>
        <td>
            <span class="badge bg-secondary">{{ $projet->type_libelle }}</span>
        </td>
        <td>{{ $projet->nom_region }}</td>
        <td>
            <span class="badge badge-tgf-{{ $projet->statut_badge }}">
                <i class="fas {{ $projet->statut_icon }}"></i>
                {{ $projet->statut_label }}
            </span>
        </td>
        <td>
            @if($projet->budget)
                {{ number_format($projet->budget, 0, ',', ' ') }} FCFA
            @else
                -
            @endif
        </td>
        <td>
            <small>{{ $projet->date_debut_formatee }}</small>
            <br>
            <small class="text-muted">→ {{ $projet->date_fin_formatee }}</small>
        </td>
        <td>
            <div class="d-flex justify-content-center gap-1 flex-wrap">
                <button class="btn btn-sm btn-primary btn-edit-projet" data-id="{{ $projet->id }}" title="Modifier">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-delete-projet"
                        data-id="{{ $projet->id }}"
                        data-titre="{{ $projet->titre }}"
                        title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center py-4 text-muted">
            <i class="fas fa-diagram-project fa-2x d-block mb-2"></i>
            Aucun projet trouvé
        </td>
    </tr>
@endforelse
