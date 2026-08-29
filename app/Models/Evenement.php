<?php

namespace App\Models;

use App\Types\TypeEvenement;
use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;

    protected $table = 'evenements';

    protected $fillable = [
        'titre',
        'description',
        'date_evenement',
        'lieu',
        'type_evenement',
        'image',
        'etat',
    ];

    protected $casts = [
        'type_evenement' => 'integer',
        'date_evenement' => 'date',
        'etat' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Vérifier si l'événement est actif
     */
    public function isActif(): bool
    {
        return $this->etat === TypeEtat::ACTIF;
    }

    /**
     * Vérifier si l'événement est supprimé
     */
    public function isSupprime(): bool
    {
        return $this->etat === TypeEtat::SUPPRIME;
    }

    /**
     * Vérifier si l'événement est passé
     */
    public function isPasse(): bool
    {
        return $this->date_evenement && $this->date_evenement->isPast();
    }

    /**
     * Vérifier si l'événement est à venir
     */
    public function isAVenir(): bool
    {
        return $this->date_evenement && $this->date_evenement->isFuture();
    }

    /**
     * Vérifier si l'événement est aujourd'hui
     */
    public function isAujourdhui(): bool
    {
        return $this->date_evenement && $this->date_evenement->isToday();
    }

    /**
     * Accesseur pour le type label
     */
    public function getTypeLabelAttribute(): string
    {
        return TypeEvenement::getLabel($this->type_evenement);
    }

    /**
     * Accesseur pour le badge de type
     */
    public function getTypeBadgeAttribute(): string
    {
        return TypeEvenement::getBadge($this->type_evenement);
    }

    /**
     * Accesseur pour l'icône du type
     */
    public function getTypeIconAttribute(): string
    {
        return TypeEvenement::getIcon($this->type_evenement);
    }

    /**
     * Accesseur pour la couleur du type
     */
    public function getTypeColorAttribute(): string
    {
        return TypeEvenement::getColor($this->type_evenement);
    }

    /**
     * Accesseur pour la date formatée
     */
    public function getDateFormateeAttribute(): string
    {
        return $this->date_evenement ? $this->date_evenement->format('d/m/Y') : '-';
    }

    /**
     * Accesseur pour la date complète formatée (avec jour)
     */
    public function getDateCompleteAttribute(): string
    {
        return $this->date_evenement
            ? $this->date_evenement->locale('fr')->isoFormat('dddd D MMMM YYYY')
            : '-';
    }

    /**
     * Accesseur pour le statut label
     */
    public function getStatutLabelAttribute(): string
    {
        if (!$this->date_evenement) {
            return 'Non défini';
        }
        if ($this->isAujourdhui()) {
            return 'Aujourd\'hui';
        }
        if ($this->isPasse()) {
            return 'Passé';
        }
        return 'À venir';
    }

    /**
     * Accesseur pour le badge de statut
     */
    public function getStatutBadgeAttribute(): string
    {
        if (!$this->date_evenement) {
            return 'secondary';
        }
        if ($this->isAujourdhui()) {
            return 'warning';
        }
        if ($this->isPasse()) {
            return 'danger';
        }
        return 'success';
    }

    /**
     * Accesseur pour l'URL de l'image
     */
    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/event-placeholder.jpg');
    }

    /**
     * Accesseur pour le statut de publication
     */
    public function getStatutPublicationLabelAttribute(): string
    {
        return $this->isActif() ? 'Publié' : 'Brouillon';
    }

    /**
     * Accesseur pour le badge de publication
     */
    public function getStatutPublicationBadgeAttribute(): string
    {
        return $this->isActif() ? 'success' : 'warning';
    }
}
