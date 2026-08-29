@forelse($communiques as $communique)
    <tr>
        <td>
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-file-pdf text-danger"></i>
                <strong>{{ $communique->titre }}</strong>
            </div>
        </td>
        <td>{{ $communique->date_publication_formatee }}</td>
        <td>
            @if($communique->resume)
                {{ Str::limit($communique->resume, 80) }}
            @else
                <span class="text-muted">-</span>
            @endif
        </td>
        <td>
            @if($communique->document_url)
                <a href="{{ route('communiques.download', $communique->id) }}" class="btn btn-sm btn-danger" title="Télécharger">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            @else
                <span class="text-muted">-</span>
            @endif
        </td>
        <td>
            <span class="badge badge-tgf-{{ $communique->statut_badge }}">
                <i class="fas fa-{{ $communique->isActif() ? 'eye' : 'pencil' }}"></i>
                {{ $communique->statut_label }}
            </span>
        </td>
        <td>
            <div class="d-flex justify-content-center gap-1">
                @if($communique->document_url)
                    <a href="{{ route('communiques.download', $communique->id) }}" class="btn btn-sm btn-success" title="Télécharger">
                        <i class="fas fa-download"></i>
                    </a>
                @endif
                <button class="btn btn-sm btn-{{ $communique->isActif() ? 'warning' : 'success' }} btn-publish"
                        data-id="{{ $communique->id }}"
                        data-published="{{ $communique->isActif() ? 1 : 0 }}"
                        title="{{ $communique->isActif() ? 'Dépublier' : 'Publier' }}">
                    <i class="fas fa-{{ $communique->isActif() ? 'eye-slash' : 'eye' }}"></i>
                </button>
                <button class="btn btn-sm btn-primary btn-edit-communique" data-id="{{ $communique->id }}" title="Modifier">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-delete-communique"
                        data-id="{{ $communique->id }}"
                        data-titre="{{ $communique->titre }}"
                        title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center py-4 text-muted">
            <i class="fas fa-file-pdf fa-2x d-block mb-2"></i>
            Aucun communiqué trouvé
        </td>
    </tr>
@endforelse
