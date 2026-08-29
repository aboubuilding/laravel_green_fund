<?php

namespace App\Models;

use App\Types\StatutProjet;
use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Projet extends Model
{
    use HasFactory;

    protected $table = 'projets';

    protected $fillable = [
        'titre',
        'slug',
        'description',
        'image',
        'region_id',
        'prefecture_id',
        'commune_id',
        'statut_projet',
        'type_projet_id',
        'budget',
        'date_debut',
        'date_fin',
        'etat',
    ];

    protected $casts = [
        'region_id' => 'integer',
        'prefecture_id' => 'integer',
        'commune_id' => 'integer',
        'statut_projet' => 'integer',
        'type_projet_id' => 'integer',
        'budget' => 'decimal:2',
        'date_debut' => 'date',
        'date_fin' => 'date',
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
        });

        static::updating(function ($model) {
            if ($model->isDirty('titre') && empty($model->slug)) {
                $model->slug = Str::slug($model->titre);
            }
        });
    }

    /**
     * Relations
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function typeProjet()
    {
        return $this->belongsTo(TypeProjet::class);
    }

    public function guichets()
    {
        return $this->belongsToMany(Guichet::class, 'guichet_projets')
            ->where('guichet_projets.etat', TypeEtat::ACTIF)
            ->withTimestamps();
    }

    public function facilites()
    {
        return $this->belongsToMany(Facilite::class, 'facilite_projets')
            ->where('facilite_projets.etat', TypeEtat::ACTIF)
            ->withTimestamps();
    }

    /**
     * Vérifier si le projet est actif
     */
    public function isActif(): bool
    {
        return $this->etat === TypeEtat::ACTIF;
    }

    /**
     * Vérifier si le projet est supprimé
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
        return StatutProjet::getLabel($this->statut_projet);
    }

    /**
     * Accesseur pour le badge de statut
     */
    public function getStatutBadgeAttribute(): string
    {
        return StatutProjet::getBadge($this->statut_projet);
    }

    /**
     * Accesseur pour l'icône du statut
     */
    public function getStatutIconAttribute(): string
    {
        return StatutProjet::getIcon($this->statut_projet);
    }

    /**
     * Accesseur pour la couleur du statut
     */
    public function getStatutColorAttribute(): string
    {
        return StatutProjet::getColor($this->statut_projet);
    }

    /**
     * Accesseur pour l'URL de l'image
     */
    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/project-placeholder.jpg');
    }

    /**
     * Accesseur pour le nom de la région
     */
    public function getNomRegionAttribute(): string
    {
        return $this->region ? $this->region->nom : '-';
    }

    /**
     * Accesseur pour le nom de la préfecture
     */
    public function getNomPrefectureAttribute(): string
    {
        return $this->prefecture ? $this->prefecture->nom : '-';
    }

    /**
     * Accesseur pour le nom de la commune
     */
    public function getNomCommuneAttribute(): string
    {
        return $this->commune ? $this->commune->nom : '-';
    }

    /**
     * Accesseur pour le type de projet
     */
    public function getTypeLibelleAttribute(): string
    {
        return $this->typeProjet ? $this->typeProjet->libelle : '-';
    }

    /**
     * Accesseur pour la date de début formatée
     */
    public function getDateDebutFormateeAttribute(): string
    {
        return $this->date_debut ? $this->date_debut->format('d/m/Y') : '-';
    }

    /**
     * Accesseur pour la date de fin formatée
     */
    public function getDateFinFormateeAttribute(): string
    {
        return $this->date_fin ? $this->date_fin->format('d/m/Y') : '-';
    }

    /**
     * Accesseur pour la durée du projet
     */
    public function getDureeAttribute(): string
    {
        if ($this->date_debut && $this->date_fin) {
            return $this->date_debut->diffInDays($this->date_fin) . ' jours';
        }
        return '-';
    }
}
