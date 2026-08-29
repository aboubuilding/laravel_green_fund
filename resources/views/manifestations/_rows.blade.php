@forelse($manifestations as $manifestation)
    <tr class="{{ $manifestation->isNouveau() ? 'table-danger' : '' }}">
        <td>{{ $manifestation->id }}</td>
        <td>
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-user text-tgf-primary"></i>
                <div>
                    <strong>{{ $manifestation->nom_complet }}</strong>
                    @if($manifestation->isNouveau())
                        <span class="badge bg-danger ms-1">Nouveau</span>
                    @endif
                </div>
            </div>
        </td>
        <td>
            @if($manifestation->email)
                <div><small>{{ $manifestation->email }}</small></div>
            @endif
            @if($manifestation->telephone)
                <div><small>{{ $manifestation->telephone }}</small></div>
            @endif
        </td>
        <td>
            @if($manifestation->type_organisation)
                <span class="badge badge-tgf-{{ $manifestation->type_organisation_badge }}">
                    {{ $manifestation->type_organisation_label }}
                </span>
            @else
                <span class="text-muted">-</span>
            @endif
        </td>
        <td>
            <div><small><strong>Guichet:</strong> {{ $manifestation->nom_guichet }}</small></div>
            <div><small><strong>Domaine:</strong> {{ $manifestation->domaine_interet_libelle }}</small></div>
        </td>
        <td>
            <span class="badge badge-tgf-{{ $manifestation->statut_badge }}">
                <i class="fas {{ $manifestation->statut_icon }}"></i>
                {{ $manifestation->statut_label }}
            </span>
        </td>
        <td>
            <small>{{ $manifestation->temps_ecoule }}</small>
        </td>
        <td>
            <div class="d-flex justify-content-center gap-1 flex-wrap">
                <button class="btn btn-sm btn-info btn-show-manifestation" data-id="{{ $manifestation->id }}" title="Consulter">
                    <i class="fas fa-eye"></i>
                </button>
                @if($manifestation->isNouveau())
                    <button class="btn btn-sm btn-success btn-traiter-manifestation" data-id="{{ $manifestation->id }}" title="Traiter">
                        <i class="fas fa-check-double"></i>
                    </button>
                @endif
                @if($manifestation->email)
                    <button class="btn btn-sm btn-primary btn-email-manifestation"
                            data-id="{{ $manifestation->id }}"
                            data-email="{{ $manifestation->email }}"
                            data-nom="{{ $manifestation->nom_complet }}"
                            title="Envoyer un email">
                        <i class="fas fa-reply"></i>
                    </button>
                @endif
                <button class="btn btn-sm btn-warning btn-edit-manifestation" data-id="{{ $manifestation->id }}" title="Modifier">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-delete-manifestation"
                        data-id="{{ $manifestation->id }}"
                        data-nom="{{ $manifestation->nom_complet }}"
                        title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center py-4 text-muted">
            <i class="fas fa-envelope fa-2x d-block mb-2"></i>
            Aucune manifestation d'intérêt trouvée
        </td>
    </tr>
@endforelse
