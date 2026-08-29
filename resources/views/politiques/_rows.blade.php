@forelse($politiques as $politique)
    <tr>
        <td>
            <div class="d-flex align-items-center gap-2">
                <i class="fas {{ $politique->type_icon }} text-tgf-primary"></i>
                <div>
                    <strong>{{ $politique->titre }}</strong>
                    @if($politique->description)
                        <br>
                        <small class="text-muted">{{ Str::limit($politique->description, 60) }}</small>
                    @endif
                </div>
            </div>
        </td>
        <td>
            <span class="badge badge-tgf-{{ $politique->type_badge }}">
                <i class="fas {{ $politique->type_icon }}"></i>
                {{ $politique->type_label }}
            </span>
        </td>
        <td>
            @if($politique->fichier)
                <a href="{{ route('politiques.download', $politique->id) }}" class="btn btn-sm btn-{{ $politique->format_color }}" title="Télécharger">
                    <i class="fas {{ $politique->format_icon }}"></i>
                    {{ $politique->nom_fichier }}
                </a>
            @else
                <span class="text-muted">-</span>
            @endif
        </td>
        <td>{{ $politique->date_formatee }}</td>
        <td>
            <span class="badge badge-tgf-{{ $politique->statut_badge }}">
                <i class="fas fa-{{ $politique->isActif() ? 'eye' : 'pencil' }}"></i>
                {{ $politique->statut_label }}
            </span>
        </td>
        <td>
            <div class="d-flex justify-content-center gap-1">
                @if($politique->fichier)
                    <a href="{{ route('politiques.download', $politique->id) }}" class="btn btn-sm btn-success" title="Télécharger">
                        <i class="fas fa-download"></i>
                    </a>
                @endif
                <button class="btn btn-sm btn-{{ $politique->isActif() ? 'warning' : 'success' }} btn-publish"
                        data-id="{{ $politique->id }}"
                        data-published="{{ $politique->isActif() ? 1 : 0 }}"
                        title="{{ $politique->isActif() ? 'Dépublier' : 'Publier' }}">
                    <i class="fas fa-{{ $politique->isActif() ? 'eye-slash' : 'eye' }}"></i>
                </button>
                <button class="btn btn-sm btn-primary btn-edit-politique" data-id="{{ $politique->id }}" title="Modifier">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-delete-politique"
                        data-id="{{ $politique->id }}"
                        data-titre="{{ $politique->titre }}"
                        title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center py-4 text-muted">
            <i class="fas fa-book fa-2x d-block mb-2"></i>
            Aucune publication trouvée
        </td>
    </tr>
@endforelse
