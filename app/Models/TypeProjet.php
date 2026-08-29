<?php

namespace App\Models;

use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeProjet extends Model
{
    use HasFactory;

    protected $table = 'type_projets';

    protected $fillable = [
        'libelle',
        'etat',
    ];

    protected $casts = [
        'etat' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function projets()
    {
        return $this->hasMany(Projet::class);
    }

    public function isActif(): bool
    {
        return $this->etat === TypeEtat::ACTIF;
    }

    public function getStatutLabelAttribute(): string
    {
        return $this->isActif() ? 'Actif' : 'Inactif';
    }

    public function getStatutBadgeAttribute(): string
    {
        return $this->isActif() ? 'success' : 'warning';
    }
}
