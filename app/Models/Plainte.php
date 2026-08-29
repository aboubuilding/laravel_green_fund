<?php

namespace App\Models;

use App\Types\StatutPlainte;
use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plainte extends Model
{
    use HasFactory;

    protected $table = 'plaintes';

    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'objet',
        'description',
        'statut',
        'reponse',
        'etat',
    ];

    protected $casts = [
        'etat' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Vérifier si la plainte est active
     */
    public function isActif(): bool
    {
        return $this->etat === TypeEtat::ACTIF;
    }

    /**
     * Vérifier si la plainte est supprimée
     */
    public function isSupprime(): bool
    {
        return $this->etat === TypeEtat::SUPPRIME;
    }

    /**
     * Vérifier si la plainte est nouvelle
     */
    public function isNouvelle(): bool
    {
        return $this->statut === StatutPlainte::NOUVELLE;
    }

    /**
     * Vérifier si la plainte est en cours
     */
    public function isEnCours(): bool
    {
        return $this->statut === StatutPlainte::EN_COURS;
    }

    /**
     * Vérifier si la plainte est résolue
     */
    public function isResolue(): bool
    {
        return $this->statut === StatutPlainte::RESOLUE;
    }

    /**
     * Accesseur pour le statut label
     */
    public function getStatutLabelAttribute(): string
    {
        return StatutPlainte::getLabel($this->statut);
    }

    /**
     * Accesseur pour le badge de statut
     */
    public function getStatutBadgeAttribute(): string
    {
        return StatutPlainte::getBadge($this->statut);
    }

    /**
     * Accesseur pour l'icône du statut
     */
    public function getStatutIconAttribute(): string
    {
        return StatutPlainte::getIcon($this->statut);
    }

    /**
     * Accesseur pour la couleur du statut
     */
    public function getStatutColorAttribute(): string
    {
        return StatutPlainte::getColor($this->statut);
    }

    /**
     * Accesseur pour la date formatée
     */
    public function getDateFormateeAttribute(): string
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    /**
     * Accesseur pour le temps écoulé
     */
    public function getTempsEcouleAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }
}
