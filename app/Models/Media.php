<?php
namespace App\Models;

use App\Types\TypeMedia;
use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';

    protected $fillable = [
        'url',
        'miniature',
        'type_media',
        'description',
        'date',
        'etat',
    ];

    protected $casts = [
        'type_media' => 'integer',
        'date' => 'date',
        'etat' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Vérifier si le média est actif
     */
    public function isActif(): bool
    {
        return $this->etat === TypeEtat::ACTIF;
    }

    /**
     * Vérifier si le média est supprimé
     */
    public function isSupprime(): bool
    {
        return $this->etat === TypeEtat::SUPPRIME;
    }

    /**
     * Vérifier si c'est une photo
     */
    public function isPhoto(): bool
    {
        return $this->type_media === TypeMedia::PHOTO;
    }

    /**
     * Vérifier si c'est une vidéo
     */
    public function isVideo(): bool
    {
        return $this->type_media === TypeMedia::VIDEO;
    }

    /**
     * Accesseur pour le type label
     */
    public function getTypeLabelAttribute(): string
    {
        return TypeMedia::getLabel($this->type_media);
    }

    /**
     * Accesseur pour le badge de type
     */
    public function getTypeBadgeAttribute(): string
    {
        return TypeMedia::getBadge($this->type_media);
    }

    /**
     * Accesseur pour l'icône du type
     */
    public function getTypeIconAttribute(): string
    {
        return TypeMedia::getIcon($this->type_media);
    }

    /**
     * Accesseur pour le nom du fichier
     */
    public function getNomFichierAttribute(): string
    {
        return basename($this->url);
    }

    /**
     * Accesseur pour l'extension du fichier
     */
    public function getExtensionAttribute(): string
    {
        return pathinfo($this->url, PATHINFO_EXTENSION);
    }

    /**
     * Accesseur pour l'URL complète
     */
    public function getUrlCompleteAttribute(): string
    {
        return asset('storage/' . $this->url);
    }

    /**
     * Accesseur pour la miniature complète
     */
    public function getMiniatureCompleteAttribute(): ?string
    {
        if ($this->miniature) {
            return asset('storage/' . $this->miniature);
        }
        return null;
    }

    /**
     * Accesseur pour la date formatée
     */
    public function getDateFormateeAttribute(): string
    {
        return $this->date ? $this->date->format('d/m/Y') : '-';
    }
}
