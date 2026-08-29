<?php

namespace App\Models;

use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuichetProjet extends Model
{
    use HasFactory;

    protected $table = 'guichet_projets';

    protected $fillable = [
        'guichet_id',
        'projet_id',
        'etat',
    ];

    protected $casts = [
        'guichet_id' => 'integer',
        'projet_id' => 'integer',
        'etat' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function guichet()
    {
        return $this->belongsTo(Guichet::class);
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
