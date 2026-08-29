<?php

namespace App\Models;

use App\Types\StatutActualite;
use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Actualite extends Model
{
    use HasFactory;

    protected $table = 'actualites';

    protected $fillable = [
        'titre',
        'slug',
        'extrait',
        'contenu',
        'image',
        'date_publication',
        'statut_actualite',
        'etat',
    ];

    protected $casts = [
        'statut_actualite' => 'integer',
        'date_publication' => 'date',
        'etat' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot du modèle
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->titre);
            }
            if (empty($model->extrait)) {
                $model->extrait = Str::limit(strip_tags($model->contenu), 150);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('titre') && empty($model->slug)) {
                $model->slug = Str::slug($model->titre);
            }
            if ($model->isDirty('contenu') && empty($model->extrait)) {
                $model->extrait = Str::limit(strip_tags($model->contenu), 150);
            }
        });
    }

    /**
     * Vérifier si l'actualité est publiée
     */
    public function isPublie(): bool
    {
        return $this->statut_actualite === StatutActualite::PUBLIE && $this->etat === TypeEtat::ACTIF;
    }

    /**
     * Vérifier si l'actualité est un brouillon
     */
    public function isBrouillon(): bool
    {
        return $this->statut_actualite === StatutActualite::BROUILLON;
    }

    /**
     * Vérifier si l'actualité est supprimée
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
        return StatutActualite::getLabel($this->statut_actualite);
    }

    /**
     * Accesseur pour le badge de statut
     */
    public function getStatutBadgeAttribute(): string
    {
        return StatutActualite::getBadge($this->statut_actualite);
    }

    /**
     * Accesseur pour l'icône du statut
     */
    public function getStatutIconAttribute(): string
    {
        return StatutActualite::getIcon($this->statut_actualite);
    }

    /**
     * Accesseur pour la date de publication formatée
     */
    public function getDatePublicationFormateeAttribute(): string
    {
        return $this->date_publication ? $this->date_publication->format('d/m/Y') : '-';
    }

    /**
     * Accesseur pour l'URL de l'image
     */
    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/no-image.png');
    }

    /**
     * Accesseur pour l'extrait tronqué
     */
    public function getExtraitCourtAttribute(): string
    {
        return Str::limit($this->extrait ?? strip_tags($this->contenu), 100);
    }

    /**
     * Accesseur pour le contenu sans balises HTML
     */
    public function getContenuTexteAttribute(): string
    {
        return strip_tags($this->contenu);
    }
}
