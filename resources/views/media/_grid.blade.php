@forelse($media as $item)
    <div class="col-md-3 col-sm-6">
        <div class="media-card">
            <div class="media-thumb">
                @if($item->miniature)
                    <img src="{{ asset('storage/' . $item->miniature) }}" alt="{{ $item->description }}">
                @else
                    <div class="placeholder-icon">
                        <i class="fas {{ $item->type_icon }}"></i>
                    </div>
                @endif
                <span class="media-badge badge badge-tgf-{{ $item->type_badge }}">
                    <i class="fas {{ $item->type_icon }}"></i>
                    {{ $item->type_label }}
                </span>
            </div>
            <div class="media-body">
                <div class="media-description">
                    {{ $item->description ?? 'Sans description' }}
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="media-date">
                        <i class="fas fa-calendar-alt"></i>
                        {{ $item->date_formatee }}
                    </span>
                    <div class="media-actions">
                        <button class="btn btn-sm btn-primary btn-edit-media" data-id="{{ $item->id }}" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-delete-media"
                                data-id="{{ $item->id }}"
                                data-description="{{ $item->description }}"
                                title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <div class="text-center py-5 text-muted">
            <i class="fas fa-photo-video fa-3x d-block mb-3"></i>
            <p>Aucun média trouvé</p>
        </div>
    </div>
@endforelse
