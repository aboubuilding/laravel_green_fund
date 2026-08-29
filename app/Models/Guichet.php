<?php

namespace App\Models;

use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Guichet extends Model
{
    use HasFactory;

    protected $table = 'guichets';

    protected $fillable = [
        'nom',
        'slug',
        'description',
        'icone',
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
        return $this->belongsToMany(Projet::class, 'guichet_projets')
            ->where('guichet_projets.etat', TypeEtat::ACTIF)
            ->withTimestamps();
    }

    public function chiffres()
    {
        return $this->hasMany(GuichetChiffre::class)
            ->where('etat', TypeEtat::ACTIF);
    }

    /**
     * Vérifier si le guichet est actif
     */
    public function isActif(): bool
    {
        return $this->etat === TypeEtat::ACTIF;
    }

    /**
     * Vérifier si le guichet est supprimé
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
     * Accesseur pour l'icône complète
     */
    public function getIconeHtmlAttribute(): string
    {
        return $this->icone ? '<i class="' . $this->icone . '"></i>' : '<i class="fas fa-folder"></i>';
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
     * Accesseur pour l'URL du guichet
     */
    public function getUrlAttribute(): string
    {
        return route('guichet.show', $this->slug);
    }
}
