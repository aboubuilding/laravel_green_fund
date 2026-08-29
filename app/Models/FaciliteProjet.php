<?php

namespace App\Models;

use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaciliteProjet extends Model
{
    use HasFactory;

    protected $table = 'facilite_projets';

    protected $fillable = [
        'facilite_id',
        'projet_id',
        'etat',
    ];

    protected $casts = [
        'facilite_id' => 'integer',
        'projet_id' => 'integer',
        'etat' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function facilite()
    {
        return $this->belongsTo(Facilite::class);
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function isActif(): bool
    {
        return $this->etat === TypeEtat::ACTIF;
    }
}
