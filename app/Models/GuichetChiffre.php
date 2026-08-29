<?php

namespace App\Models;

use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuichetChiffre extends Model
{
    use HasFactory;

    protected $table = 'guichet_chiffres';

    protected $fillable = [
        'guichet_id',
        'valeur',
        'libelle',
        'etat',
    ];

    protected $casts = [
        'guichet_id' => 'integer',
        'etat' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function guichet()
    {
        return $this->belongsTo(Guichet::class);
    }

    public function isActif(): bool
    {
        return $this->etat === TypeEtat::ACTIF;
    }

    public function isSupprime(): bool
    {
        return $this->etat === TypeEtat::SUPPRIME;
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
