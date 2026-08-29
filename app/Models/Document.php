<?php

namespace App\Models;

use App\Types\CategorieDocument;
use App\Types\TypeDocument;
use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';

    protected $fillable = [
        'titre',
        'categorie_document',
        'type',
        'format',
        'taille',
        'date',
        'url',
        'description',
        'etat',
    ];

    protected $casts = [
        'categorie_document' => 'integer',
        'date' => 'date',
        'etat' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Vérifier si le document est actif
     */
    public function isActif(): bool
    {
        return $this->etat === TypeEtat::ACTIF;
    }

    /**
     * Vérifier si le document est supprimé
     */
    public function isSupprime(): bool
    {
        return $this->etat === TypeEtat::SUPPRIME;
    }

    /**
     * Accesseur pour la catégorie label
     */
    public function getCategorieLabelAttribute(): string
    {
        return CategorieDocument::getLabel($this->categorie_document);
    }

    /**
     * Accesseur pour le badge de catégorie
     */
    public function getCategorieBadgeAttribute(): string
    {
        return CategorieDocument::getBadge($this->categorie_document);
    }

    /**
     * Accesseur pour le type label
     */
    public function getTypeLabelAttribute(): string
    {
        return TypeDocument::getLabel($this->type);
    }

    /**
     * Accesseur pour le badge de type
     */
    public function getTypeBadgeAttribute(): string
    {
        return TypeDocument::getBadge($this->type);
    }

    /**
     * Accesseur pour la taille formatée
     */
    public function getTailleFormateeAttribute(): string
    {
        if (!$this->taille) {
            return '-';
        }

        $taille = (int) $this->taille;
        $unites = ['o', 'Ko', 'Mo', 'Go'];
        $i = 0;

        while ($taille >= 1024 && $i < count($unites) - 1) {
            $taille /= 1024;
            $i++;
        }

        return round($taille, 1) . ' ' . $unites[$i];
    }

    /**
     * Accesseur pour le nom du fichier
     */
    public function getNomFichierAttribute(): string
    {
        return basename($this->url);
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
            'ppt' => 'fa-file-powerpoint',
            'pptx' => 'fa-file-powerpoint',
            'zip' => 'fa-file-archive',
            'rar' => 'fa-file-archive',
            'jpg' => 'fa-file-image',
            'jpeg' => 'fa-file-image',
            'png' => 'fa-file-image',
            'gif' => 'fa-file-image',
            'mp4' => 'fa-file-video',
            'avi' => 'fa-file-video',
            'mp3' => 'fa-file-audio',
        ];

        $format = strtolower($this->format);
        return $icons[$format] ?? 'fa-file';
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
            'ppt' => 'warning',
            'pptx' => 'warning',
            'zip' => 'secondary',
            'rar' => 'secondary',
            'jpg' => 'info',
            'jpeg' => 'info',
            'png' => 'info',
        ];

        $format = strtolower($this->format);
        return $colors[$format] ?? 'secondary';
    }
}
