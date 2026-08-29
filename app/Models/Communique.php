<?php

namespace App\Models;

use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Communique extends Model
{
    use HasFactory;

    protected $table = 'communiques';

    protected $fillable = [
        'titre',
        'date_publication',
        'resume',
        'document_url',
        'etat',
    ];

    protected $casts = [
        'date_publication' => 'date',
        'etat' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Vérifier si le communiqué est actif
     */
    public function isActif(): bool
    {
        return $this->etat === TypeEtat::ACTIF;
    }

    /**
     * Vérifier si le communiqué est supprimé
     */
    public function isSupprime(): bool
    {
        return $this->etat === TypeEtat::SUPPRIME;
    }

    /**
     * Accesseur pour la date de publication formatée
     */
    public function getDatePublicationFormateeAttribute(): string
    {
        return $this->date_publication ? $this->date_publication->format('d/m/Y') : '-';
    }

    /**
     * Accesseur pour le nom du fichier
     */
    public function getNomFichierAttribute(): string
    {
        return $this->document_url ? basename($this->document_url) : '-';
    }

    /**
     * Accesseur pour l'extension du fichier
     */
    public function getExtensionAttribute(): string
    {
        return $this->document_url ? pathinfo($this->document_url, PATHINFO_EXTENSION) : '';
    }

    /**
     * Accesseur pour l'URL complète du fichier
     */
    public function getDocumentUrlAttribute(): string
    {
        return $this->document_url ? asset('storage/' . $this->document_url) : '';
    }

    /**
     * Accesseur pour le statut label
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

    /**
     * Accesseur pour l'icône du format PDF
     */
    public function getFormatIconAttribute(): string
    {
        return 'fa-file-pdf';
    }

    /**
     * Accesseur pour la couleur du format
     */
    public function getFormatColorAttribute(): string
    {
        return 'danger';
    }
}
