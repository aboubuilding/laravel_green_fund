@forelse($projetFinances as $projetFinance)
    <tr class="{{ $projetFinance->mise_en_avant ? 'table-warning' : '' }}">
        <td>
            <img src="{{ $projetFinance->image_url }}" alt="{{ $projetFinance->titre_projet }}"
                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
        </td>
        <td>
            <div>
                <strong>{{ $projetFinance->titre_projet }}</strong>
                @if($projetFinance->mise_en_avant)
                    <span class="badge bg-warning ms-1">
                        <i class="fas fa-crown"></i> En avant
                    </span>
                @endif
            </div>
        </td>
        <td>
            <strong class="text-success">{{ $projetFinance->montant_formate }}</strong>
        </td>
        <td>
            @if($projetFinance->partenaire)
                <div class="d-flex align-items-center gap-2">
                    @if($projetFinance->partenaire->logo)
                        <img src="{{ asset('storage/' . $projetFinance->partenaire->logo) }}"
                             alt="{{ $projetFinance->nom_partenaire }}"
                             style="width: 24px; height: 24px; object-fit: contain;">
                    @endif
                    <span>{{ $projetFinance->nom_partenaire }}</span>
                </div>
            @else
                <span class="text-muted">-</span>
            @endif
        </td>
        <td>
            <span class="badge bg-secondary">{{ $projetFinance->annee ?? '-' }}</span>
        </td>
        <td>
            <span class="badge badge-tgf-{{ $projetFinance->mise_en_avant_badge }}">
                {{ $projetFinance->mise_en_avant_label }}
            </span>
        </td>
        <td>
            <div class="d-flex justify-content-center gap-1 flex-wrap">
                <button class="btn btn-sm btn-{{ $projetFinance->mise_en_avant ? 'warning' : 'success' }} btn-toggle-mise-en-avant"
                        data-id="{{ $projetFinance->id }}"
                        data-mise-en-avant="{{ $projetFinance->mise_en_avant ? 1 : 0 }}"
                        title="{{ $projetFinance->mise_en_avant ? 'Retirer de la mise en avant' : 'Mettre en avant' }}">
                    <i class="fas fa-{{ $projetFinance->mise_en_avant ? 'eye-slash' : 'crown' }}"></i>
                </button>
                <button class="btn btn-sm btn-primary btn-edit-projet-finance" data-id="{{ $projetFinance->id }}" title="Modifier">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-delete-projet-finance"
                        data-id="{{ $projetFinance->id }}"
                        data-titre="{{ $projetFinance->titre_projet }}"
                        title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center py-4 text-muted">
            <i class="fas fa-star fa-2x d-block mb-2"></i>
            Aucun projet financé trouvé
        </td>
    </tr>
@endforelse
