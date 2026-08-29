<?php

namespace App\Models;

use App\Types\StatutSoumission;
use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoumissionHistorique extends Model
{
    use HasFactory;

    protected $table = 'soumission_historiques';

    protected $fillable = [
        'soumission_id',
        'statut_soumission',
        'commentaire',
        'auteur_id',
        'date_action',
        'etat',
    ];

    protected $casts = [
        'soumission_id' => 'integer',
        'statut_soumission' => 'integer',
        'auteur_id' => 'integer',
        'date_action' => 'datetime',
        'etat' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function soumission()
    {
        return $this->belongsTo(Soumission::class);
    }

    public function auteur()
    {
        return $this->belongsTo(User::class, 'auteur_id');
    }

    public function isActif(): bool
    {
        return $this->etat === TypeEtat::ACTIF;
    }

    public function getStatutLabelAttribute(): string
    {
        return StatutSoumission::getLabel($this->statut_soumission);
    }

    public function getDateActionFormateeAttribute(): string
    {
        return $this->date_action ? $this->date_action->format('d/m/Y H:i') : '-';
    }

    public function getTempsEcouleAttribute(): string
    {
        return $this->date_action ? $this->date_action->diffForHumans() : '-';
    }
}
