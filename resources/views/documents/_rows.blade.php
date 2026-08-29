@forelse($documents as $document)
    <tr>
        <td>
            <div class="d-flex align-items-center gap-2">
                <i class="fas {{ $document->format_icon }} text-{{ $document->format_color }}"></i>
                <div>
                    <strong>{{ $document->titre }}</strong>
                    @if($document->description)
                        <br>
                        <small class="text-muted">{{ Str::limit($document->description, 50) }}</small>
                    @endif
                </div>
            </div>
        </td>
        <td>
            <span class="badge badge-tgf-{{ $document->categorie_badge }}">
                {{ $document->categorie_label }}
            </span>
        </td>
        <td>
            <span class="badge badge-tgf-{{ $document->type_badge }}">
                {{ $document->type_label }}
            </span>
        </td>
        <td>
            <span class="badge bg-{{ $document->format_color }}">
                {{ strtoupper($document->format) }}
            </span>
        </td>
        <td>{{ $document->taille_formatee }}</td>
        <td>{{ $document->date ? $document->date->format('d/m/Y') : '-' }}</td>
        <td>
            <div class="d-flex justify-content-center gap-1">
                <a href="{{ route('documents.download', $document->id) }}" class="btn btn-sm btn-success" title="Télécharger">
                    <i class="fas fa-download"></i>
                </a>
                <button class="btn btn-sm btn-primary btn-edit-doc" data-id="{{ $document->id }}" title="Modifier">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-delete-doc"
                        data-id="{{ $document->id }}"
                        data-titre="{{ $document->titre }}"
                        title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center py-4 text-muted">
            <i class="fas fa-file-alt fa-2x d-block mb-2"></i>
            Aucun document trouvé
        </td>
    </tr>
@endforelse
