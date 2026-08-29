<?php

namespace App\Models;

use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Facilite extends Model
{
    use HasFactory;

    protected $table = 'facilites';

    protected $fillable = [
        'nom',
        'slug',
        'description',
        'etat',
    ];

    protected $casts = [
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
                $model->slug = Str::slug($model->nom);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('nom') && empty($model->slug)) {
                $model->slug = Str::slug($model->nom);
            }
        });
    }

    /**
     * Relations
     */
    public function projets()
    {
        return $this->belongsToMany(Projet::class, 'facilite_projets')
            ->where('facilite_projets.etat', TypeEtat::ACTIF)
            ->withTimestamps();
    }

    public function chiffres()
    {
        return $this->hasMany(FaciliteChiffre::class)
            ->where('etat', TypeEtat::ACTIF);
    }

    /**
     * Vérifier si la facilité est active
     */
    public function isActif(): bool
    {
        return $this->etat === TypeEtat::ACTIF;
    }

    /**
     * Vérifier si la facilité est supprimée
     */
    public function isSupprime(): bool
    {
        return $this->etat === TypeEtat::SUPPRIME;
    }

    /**
     * Accesseur pour le nombre de projets liés
     */
    public function getNbProjetsAttribute(): int
    {
        return $this->projets()->count();
    }

    /**
     * Accesseur pour le statut label
     */
    public function getStatutLabelAttribute(): string
    {
        return $this->isActif() ? 'Actif' : 'Inactif';
    }

    /**
     * Accesseur pour le badge de statut
     */
    public function getStatutBadgeAttribute(): string
    {
        return $this->isActif() ? 'success' : 'warning';
    }

    /**
     * Accesseur pour l'URL de la facilité
     */
    public function getUrlAttribute(): string
    {
        return route('facilite.show', $this->slug);
    }
}
