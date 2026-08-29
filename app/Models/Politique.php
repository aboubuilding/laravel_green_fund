<?php

namespace App\Models;

use App\Types\TypePolitique;
use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Politique extends Model
{
    use HasFactory;

    protected $table = 'politiques';

    protected $fillable = [
        'titre',
        'type_politique_id',
        'fichier',
        'date',
        'description',
        'etat',
    ];

    protected $casts = [
        'type_politique_id' => 'integer',
        'date' => 'date',
        'etat' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Vérifier si la politique est active
     */
    public function isActif(): bool
    {
        return $this->etat === TypeEtat::ACTIF;
    }

    /**
     * Vérifier si la politique est supprimée
     */
    public function isSupprime(): bool
    {
        return $this->etat === TypeEtat::SUPPRIME;
    }

    /**
     * Accesseur pour le type label
     */
    public function getTypeLabelAttribute(): string
    {
        return TypePolitique::getLabel($this->type_politique_id);
    }

    /**
     * Accesseur pour le badge de type
     */
    public function getTypeBadgeAttribute(): string
    {
        return TypePolitique::getBadge($this->type_politique_id);
    }

    /**
     * Accesseur pour l'icône du type
     */
    public function getTypeIconAttribute(): string
    {
        return TypePolitique::getIcon($this->type_politique_id);
    }

    /**
     * Accesseur pour le nom du fichier
     */
    public function getNomFichierAttribute(): string
    {
        return $this->fichier ? basename($this->fichier) : '-';
    }

    /**
     * Accesseur pour l'extension du fichier
     */
    public function getExtensionAttribute(): string
    {
        return $this->fichier ? pathinfo($this->fichier, PATHINFO_EXTENSION) : '';
    }

    /**
     * Accesseur pour l'URL complète du fichier
     */
    public function getFichierUrlAttribute(): string
    {
        return $this->fichier ? asset('storage/' . $this->fichier) : '';
    }

    /**
     * Accesseur pour la date formatée
     */
    public function getDateFormateeAttribute(): string
    {
        return $this->date ? $this->date->format('d/m/Y') : '-';
    }

    /**
     * Accesseur pour l'icône selon le format
     */
    public function getFormatIconAttribute(): string
    {
        $icons = [
            'pdf' => 'fa-file-pdf',
            'doc' => 'fa-file-word',
            'docx' => 'fa-file-word',
            'xls' => 'fa-file-excel',
            'xlsx' => 'fa-file-excel',
        ];
        $extension = strtolower($this->extension);
        return $icons[$extension] ?? 'fa-file';
    }

    /**
     * Accesseur pour la couleur du format
     */
    public function getFormatColorAttribute(): string
    {
        $colors = [
            'pdf' => 'danger',
            'doc' => 'primary',
            'docx' => 'primary',
            'xls' => 'success',
            'xlsx' => 'success',
        ];
        $extension = strtolower($this->extension);
        return $colors[$extension] ?? 'secondary';
    }

    /**
     * Accesseur pour le statut publié
     */
    public function getStatutLabelAttribute(): string
    {
        return $this->isActif() ? 'Publié' : 'Brouillon';
    }

    /**
     * Accesseur pour le badge de statut
     */
    public function getStatutBadgeAttribute(): string
    {
        return $this->isActif() ? 'success' : 'warning';
    }
}
