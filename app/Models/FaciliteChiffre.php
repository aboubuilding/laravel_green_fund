<?php

namespace App\Models;

use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaciliteChiffre extends Model
{
    use HasFactory;

    protected $table = 'facilite_chiffres';

    protected $fillable = [
        'facilite_id',
        'valeur',
        'libelle',
        'etat',
    ];

    protected $casts = [
        'facilite_id' => 'integer',
        'etat' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function facilite()
    {
        return $this->belongsTo(Facilite::class);
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
