<?php

namespace App\Models;

use App\Types\StatutGrief;
use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grief extends Model
{
    use HasFactory;

    protected $table = 'griefs';

    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'projet_concerne_id',
        'description',
        'statut',
        'reponse',
        'etat',
    ];

    protected $casts = [
        'projet_concerne_id' => 'integer',
        'etat' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relations
     */
    public function projet()
    {
        return $this->belongsTo(Projet::class, 'projet_concerne_id');
    }

    /**
     * Vérifier si le grief est actif
     */
    public function isActif(): bool
    {
        return $this->etat === TypeEtat::ACTIF;
    }

    /**
     * Vérifier si le grief est supprimé
     */
    public function isSupprime(): bool
    {
        return $this->etat === TypeEtat::SUPPRIME;
    }

    /**
     * Vérifier si le grief est nouveau
     */
    public function isNouveau(): bool
    {
        return $this->statut === StatutGrief::NOUVEAU;
    }

    /**
     * Vérifier si le grief est en cours
     */
    public function isEnCours(): bool
    {
        return $this->statut === StatutGrief::EN_COURS;
    }

    /**
     * Vérifier si le grief est résolu
     */
    public function isResolu(): bool
    {
        return $this->statut === StatutGrief::RESOLU;
    }

    /**
     * Accesseur pour le statut label
     */
    public function getStatutLabelAttribute(): string
    {
        return StatutGrief::getLabel($this->statut);
    }

    /**
     * Accesseur pour le badge de statut
     */
    public function getStatutBadgeAttribute(): string
    {
        return StatutGrief::getBadge($this->statut);
    }

    /**
     * Accesseur pour l'icône du statut
     */
    public function getStatutIconAttribute(): string
    {
        return StatutGrief::getIcon($this->statut);
    }

    /**
     * Accesseur pour la couleur du statut
     */
    public function getStatutColorAttribute(): string
    {
        return StatutGrief::getColor($this->statut);
    }

    /**
     * Accesseur pour le nom du projet
     */
    public function getNomProjetAttribute(): string
    {
        return $this->projet ? $this->projet->titre : 'Non spécifié';
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
