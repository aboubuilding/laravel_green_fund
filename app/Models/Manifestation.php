<?php
namespace App\Models;

use App\Types\StatutManifestation;
use App\Types\TypeOrganisation;
use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manifestation extends Model
{
    use HasFactory;

    protected $table = 'manifestations';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'type_organisation',
        'telephone',
        'guichet_id',
        'domaine_interet_id',
        'message',
        'document_manifestation',
        'statut_manifestation',
        'etat',
    ];

    protected $casts = [
        'type_organisation' => 'integer',
        'guichet_id' => 'integer',
        'domaine_interet_id' => 'integer',
        'statut_manifestation' => 'integer',
        'etat' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relations
     */
    public function guichet()
    {
        return $this->belongsTo(Guichet::class);
    }

    public function domaineInteret()
    {
        return $this->belongsTo(DomaineInteret::class);
    }

    /**
     * Vérifier si la manifestation est active
     */
    public function isActif(): bool
    {
        return $this->etat === TypeEtat::ACTIF;
    }

    /**
     * Vérifier si la manifestation est supprimée
     */
    public function isSupprime(): bool
    {
        return $this->etat === TypeEtat::SUPPRIME;
    }

    /**
     * Vérifier si la manifestation est nouvelle
     */
    public function isNouveau(): bool
    {
        return $this->statut_manifestation === StatutManifestation::NOUVEAU;
    }

    /**
     * Vérifier si la manifestation est traitée
     */
    public function isTraite(): bool
    {
        return $this->statut_manifestation === StatutManifestation::TRAITE;
    }

    /**
     * Accesseur pour le statut label
     */
    public function getStatutLabelAttribute(): string
    {
        return StatutManifestation::getLabel($this->statut_manifestation);
    }

    /**
     * Accesseur pour le badge de statut
     */
    public function getStatutBadgeAttribute(): string
    {
        return StatutManifestation::getBadge($this->statut_manifestation);
    }

    /**
     * Accesseur pour l'icône du statut
     */
    public function getStatutIconAttribute(): string
    {
        return StatutManifestation::getIcon($this->statut_manifestation);
    }

    /**
     * Accesseur pour le type d'organisation label
     */
    public function getTypeOrganisationLabelAttribute(): string
    {
        return TypeOrganisation::getLabel($this->type_organisation);
    }

    /**
     * Accesseur pour le badge du type d'organisation
     */
    public function getTypeOrganisationBadgeAttribute(): string
    {
        return TypeOrganisation::getBadge($this->type_organisation);
    }

    /**
     * Accesseur pour le nom complet
     */
    public function getNomCompletAttribute(): string
    {
        return trim($this->prenom . ' ' . $this->nom);
    }

    /**
     * Accesseur pour le nom du guichet
     */
    public function getNomGuichetAttribute(): string
    {
        return $this->guichet ? $this->guichet->nom : '-';
    }

    /**
     * Accesseur pour le domaine d'intérêt
     */
    public function getDomaineInteretLibelleAttribute(): string
    {
        return $this->domaineInteret ? $this->domaineInteret->libelle : '-';
    }

    /**
     * Accesseur pour la date formatée
     */
    public function getDateFormateeAttribute(): string
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    /**
     * Accesseur pour le temps écoulé
     */
    public function getTempsEcouleAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Accesseur pour le nom du fichier
     */
    public function getNomFichierAttribute(): ?string
    {
        return $this->document_manifestation ? basename($this->document_manifestation) : null;
    }

    /**
     * Accesseur pour l'URL du fichier
     */
    public function getDocumentUrlAttribute(): ?string
    {
        return $this->document_manifestation ? asset('storage/' . $this->document_manifestation) : null;
    }
}
