<?php

namespace App\Models;

use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjetFinance extends Model
{
    use HasFactory;

    protected $table = 'projet_finances';

    protected $fillable = [
        'projet_id',
        'montant_finance',
        'partenaire_id',
        'annee',
        'mise_en_avant',
        'etat',
    ];

    protected $casts = [
        'projet_id' => 'integer',
        'partenaire_id' => 'integer',
        'montant_finance' => 'decimal:2',
        'annee' => 'integer',
        'mise_en_avant' => 'boolean',
        'etat' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relations
     */
    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function partenaire()
    {
        return $this->belongsTo(Partenaire::class);
    }

    /**
     * Vérifier si le projet financé est actif
     */
    public function isActif(): bool
    {
        return $this->etat === TypeEtat::ACTIF;
    }

    /**
     * Vérifier si le projet financé est supprimé
     */
    public function isSupprime(): bool
    {
        return $this->etat === TypeEtat::SUPPRIME;
    }

    /**
     * Vérifier si le projet est mis en avant
     */
    public function isMiseEnAvant(): bool
    {
        return $this->mise_en_avant;
    }

    /**
     * Accesseur pour le titre du projet
     */
    public function getTitreProjetAttribute(): string
    {
        return $this->projet ? $this->projet->titre : 'Projet supprimé';
    }

    /**
     * Accesseur pour l'image du projet
     */
    public function getImageProjetAttribute(): ?string
    {
        return $this->projet ? $this->projet->image : null;
    }

    /**
     * Accesseur pour l'URL de l'image du projet
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->projet && $this->projet->image) {
            return asset('storage/' . $this->projet->image);
        }
        return asset('images/project-placeholder.jpg');
    }

    /**
     * Accesseur pour le nom du partenaire
     */
    public function getNomPartenaireAttribute(): string
    {
        return $this->partenaire ? $this->partenaire->nom : '-';
    }

    /**
     * Accesseur pour le logo du partenaire
     */
    public function getLogoPartenaireAttribute(): ?string
    {
        return $this->partenaire ? $this->partenaire->logo : null;
    }

    /**
     * Accesseur pour le montant formaté
     */
    public function getMontantFormateAttribute(): string
    {
        return number_format($this->montant_finance, 0, ',', ' ') . ' FCFA';
    }

    /**
     * Accesseur pour le statut de mise en avant
     */
    public function getMiseEnAvantLabelAttribute(): string
    {
        return $this->mise_en_avant ? 'Oui' : 'Non';
    }

    /**
     * Accesseur pour le badge de mise en avant
     */
    public function getMiseEnAvantBadgeAttribute(): string
    {
        return $this->mise_en_avant ? 'success' : 'secondary';
    }
}
