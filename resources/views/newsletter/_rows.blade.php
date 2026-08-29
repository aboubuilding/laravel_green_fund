@forelse($newsletters as $newsletter)
    <tr>
        <td>
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-envelope text-tgf-primary"></i>
                <strong>{{ $newsletter->email }}</strong>
            </div>
        </td>
        <td>
            <span class="badge badge-tgf-{{ $newsletter->statut_badge }}">
                <i class="fas {{ $newsletter->statut_icon }}"></i>
                {{ $newsletter->statut_label }}
            </span>
        </td>
        <td>{{ $newsletter->date_inscription_formatee }}</td>
        <td>{{ $newsletter->created_at->format('d/m/Y H:i') }}</td>
        <td>
            <div class="d-flex justify-content-center gap-1">
                @if($newsletter->isActif())
                    <button class="btn btn-sm btn-danger btn-unsubscribe"
                            data-id="{{ $newsletter->id }}"
                            data-desabonne="0"
                            title="Désabonner">
                        <i class="fas fa-user-slash"></i>
                    </button>
                @elseif($newsletter->isDesabonne())
                    <button class="btn btn-sm btn-success btn-unsubscribe"
                            data-id="{{ $newsletter->id }}"
                            data-desabonne="1"
                            title="Réinscrire">
                        <i class="fas fa-undo"></i>
                    </button>
                @endif
                <button class="btn btn-sm btn-danger btn-delete-newsletter"
                        data-id="{{ $newsletter->id }}"
                        data-email="{{ $newsletter->email }}"
                        title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center py-4 text-muted">
            <i class="fas fa-envelope-open-text fa-2x d-block mb-2"></i>
            Aucun abonné trouvé
        </td>
    </tr>
@endforelse
