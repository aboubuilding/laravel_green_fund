@forelse($actualites as $actualite)
    <tr>
        <td>
            @if($actualite->image)
                <img src="{{ $actualite->image_url }}" alt="{{ $actualite->titre }}" class="image-preview">
            @else
                <div class="image-preview-placeholder">
                    <i class="fas fa-image"></i>
                </div>
            @endif
        </td>
        <td>
            <div class="d-flex flex-column">
                <strong>{{ $actualite->titre }}</strong>
                <small class="text-muted">{{ Str::limit($actualite->extrait ?? $actualite->contenu_texte, 80) }}</small>
            </div>
        </td>
        <td>
            @if($actualite->date_publication)
                <span>{{ $actualite->date_publication_formatee }}</span>
                @if($actualite->date_publication > now())
                    <span class="badge bg-info ms-1">Programmé</span>
                @endif
            @else
                <span class="text-muted">-</span>
            @endif
        </td>
        <td>
            <span class="badge badge-tgf-{{ $actualite->statut_badge }}">
                <i class="fas {{ $actualite->statut_icon }}"></i>
                {{ $actualite->statut_label }}
            </span>
            @if($actualite->statut_actualite == App\Types\StatutActualite::PUBLIE && $actualite->date_publication && $actualite->date_publication > now())
                <span class="badge bg-info ms-1">Programmé</span>
            @endif
        </td>
        <td>
            <div class="d-flex justify-content-center gap-1">
                @if($actualite->isPublie() && (!$actualite->date_publication || $actualite->date_publication <= now()))
                    <button class="btn btn-sm btn-warning btn-publish"
                            data-id="{{ $actualite->id }}"
                            data-published="1"
                            title="Dépublier">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                @else
                    <button class="btn btn-sm btn-success btn-publish"
                            data-id="{{ $actualite->id }}"
                            data-published="0"
                            title="Publier">
                        <i class="fas fa-eye"></i>
                    </button>
                @endif
                <button class="btn btn-sm btn-primary btn-edit-actualite" data-id="{{ $actualite->id }}" title="Modifier">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-delete-actualite"
                        data-id="{{ $actualite->id }}"
                        data-titre="{{ $actualite->titre }}"
                        title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center py-4 text-muted">
            <i class="fas fa-newspaper fa-2x d-block mb-2"></i>
            Aucune actualité trouvée
        </td>
    </tr>
@endforelse
