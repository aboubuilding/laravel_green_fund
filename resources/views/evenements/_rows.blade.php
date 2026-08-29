@forelse($evenements as $evenement)
    <tr>
        <td>
            <div class="d-flex align-items-center gap-2">
                @if($evenement->image)
                    <img src="{{ $evenement->image_url }}" alt="{{ $evenement->titre }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px;">
                @else
                    <div style="width: 40px; height: 40px; border-radius: 6px; background: #f0f5f2; display: flex; align-items: center; justify-content: center; color: #8AA89A;">
                        <i class="fas fa-calendar"></i>
                    </div>
                @endif
                <div>
                    <strong>{{ $evenement->titre }}</strong>
                </div>
            </div>
        </td>
        <td>
            <div>
                <span>{{ $evenement->date_formatee }}</span>
                @if($evenement->isAujourdhui())
                    <span class="badge bg-warning ms-1">Aujourd'hui</span>
                @endif
            </div>
        </td>
        <td>{{ $evenement->lieu ?? '-' }}</td>
        <td>
            <span class="badge badge-tgf-{{ $evenement->type_badge }}" style="background-color: {{ $evenement->type_color }}; color: #fff;">
                <i class="fas {{ $evenement->type_icon }}"></i>
                {{ $evenement->type_label }}
            </span>
        </td>
        <td>
            <span class="badge badge-tgf-{{ $evenement->statut_badge }}">
                <i class="fas fa-{{ $evenement->isAujourdhui() ? 'clock' : ($evenement->isPasse() ? 'history' : 'calendar-check') }}"></i>
                {{ $evenement->statut_label }}
            </span>
        </td>
        <td>
            <span class="badge badge-tgf-{{ $evenement->statut_publication_badge }}">
                <i class="fas fa-{{ $evenement->isActif() ? 'eye' : 'pencil' }}"></i>
                {{ $evenement->statut_publication_label }}
            </span>
        </td>
        <td>
            <div class="d-flex justify-content-center gap-1">
                <button class="btn btn-sm btn-{{ $evenement->isActif() ? 'warning' : 'success' }} btn-publish"
                        data-id="{{ $evenement->id }}"
                        data-published="{{ $evenement->isActif() ? 1 : 0 }}"
                        title="{{ $evenement->isActif() ? 'Dépublier' : 'Publier' }}">
                    <i class="fas fa-{{ $evenement->isActif() ? 'eye-slash' : 'eye' }}"></i>
                </button>
                <button class="btn btn-sm btn-primary btn-edit-evenement" data-id="{{ $evenement->id }}" title="Modifier">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-delete-evenement"
                        data-id="{{ $evenement->id }}"
                        data-titre="{{ $evenement->titre }}"
                        title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center py-4 text-muted">
            <i class="fas fa-calendar fa-2x d-block mb-2"></i>
            Aucun événement trouvé
        </td>
    </tr>
@endforelse
