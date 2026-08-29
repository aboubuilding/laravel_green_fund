<?php

namespace App\Models;

use App\Types\StatutNewsletter;
use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $table = 'newsletters';

    protected $fillable = [
        'email',
        'statut',
        'date_inscription',
        'etat',
    ];

    protected $casts = [
        'date_inscription' => 'datetime',
        'etat' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Vérifier si l'abonné est actif
     */
    public function isActif(): bool
    {
        return $this->statut === StatutNewsletter::ACTIF && $this->etat === TypeEtat::ACTIF;
    }

    /**
     * Vérifier si l'abonné est désabonné
     */
    public function isDesabonne(): bool
    {
        return $this->statut === StatutNewsletter::DESABONNE;
    }

    /**
     * Vérifier si l'abonné est supprimé
     */
    public function isSupprime(): bool
    {
        return $this->etat === TypeEtat::SUPPRIME;
    }

    /**
     * Accesseur pour le statut label
     */
    public function getStatutLabelAttribute(): string
    {
        return StatutNewsletter::getLabel($this->statut);
    }

    /**
     * Accesseur pour le badge de statut
     */
    public function getStatutBadgeAttribute(): string
    {
        return StatutNewsletter::getBadge($this->statut);
    }

    /**
     * Accesseur pour l'icône du statut
     */
    public function getStatutIconAttribute(): string
    {
        return StatutNewsletter::getIcon($this->statut);
    }

    /**
     * Accesseur pour la date d'inscription formatée
     */
    public function getDateInscriptionFormateeAttribute(): string
    {
        return $this->date_inscription ? $this->date_inscription->format('d/m/Y H:i') : '-';
    }
}
