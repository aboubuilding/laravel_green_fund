@forelse($soumissions as $soumission)
    <tr>
        <td>
            <strong>{{ $soumission->numero_soumission }}</strong>
        </td>
        <td>
            <div>
                <strong>{{ $soumission->titre_projet }}</strong>
                <br>
                <small class="text-muted">{{ Str::limit($soumission->resume_projet, 50) }}</small>
            </div>
        </td>
        <td>
            <div>
                <strong>{{ $soumission->porteur_nom }}</strong>
                <br>
                <small>{{ $soumission->porteur_email }}</small>
            </div>
        </td>
        <td>{{ $soumission->nom_guichet }}</td>
        <td>
            @if($soumission->montant_sollicite)
                {{ number_format($soumission->montant_sollicite, 0, ',', ' ') }} FCFA
            @else
                -
            @endif
        </td>
        <td>
            <span class="badge badge-tgf-{{ $soumission->statut_badge }}">
                <i class="fas {{ $soumission->statut_icon }}"></i>
                {{ $soumission->statut_label }}
            </span>
            <div class="progress mt-1" style="height: 4px; width: 80px;">
                <div class="progress-bar bg-{{ $soumission->statut_badge }}"
                     style="width: {{ $soumission->progression }}%"></div>
            </div>
        </td>
        <td>
            <small>{{ $soumission->date_soumission_formatee }}</small>
        </td>
        <td>
            <div class="d-flex justify-content-center gap-1 flex-wrap">
                <button class="btn btn-sm btn-info btn-show-soumission" data-id="{{ $soumission->id }}" title="Consulter">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-sm btn-{{ $soumission->statut_badge }} btn-changer-statut"
                        data-id="{{ $soumission->id }}"
                        data-statut="{{ $soumission->statut_soumission }}"
                        data-label="{{ $soumission->statut_label }}"
                        title="Changer statut">
                    <i class="fas fa-exchange-alt"></i>
                </button>
                <button class="btn btn-sm btn-warning btn-edit-soumission" data-id="{{ $soumission->id }}" title="Modifier">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-delete-soumission"
                        data-id="{{ $soumission->id }}"
                        data-titre="{{ $soumission->titre_projet }}"
                        title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center py-4 text-muted">
            <i class="fas fa-upload fa-2x d-block mb-2"></i>
            Aucune soumission trouvée
        </td>
    </tr>
@endforelse
