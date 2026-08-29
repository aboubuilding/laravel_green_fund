<?php

namespace App\Models;

use App\Types\StatutSoumission;
use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Soumission extends Model
{
    use HasFactory;

    protected $table = 'soumissions';

    protected $fillable = [
        'numero_soumission',
        'type_porteur',
        'porteur_nom',
        'porteur_fonction',
        'porteur_email',
        'qualite_signature',
        'date_demarrage',
        'fait_projet',
        'date_signature',
        'resume_projet',
        'lien_projet',
        'objet_projet',
        'theorie_projet',
        'problematique_projet',
        'implication_collectivite',
        'porteur_telephone',
        'guichet_id',
        'duree_envisagee',
        'titre_projet',
        'nombre_beneficiaire',
        'beneficiaire_indirect',
        'region_id',
        'prefecture_id',
        'commune_id',
        'montant_sollicite',
        'cout_global',
        'statut_soumission',
        'doc_statut',
        'attestation_fiscal',
        'autre_document',
        'doc_budget',
        'etat',
    ];

    protected $casts = [
        'type_porteur' => 'integer',
        'guichet_id' => 'integer',
        'region_id' => 'integer',
        'prefecture_id' => 'integer',
        'commune_id' => 'integer',
        'statut_soumission' => 'integer',
        'montant_sollicite' => 'decimal:2',
        'cout_global' => 'decimal:2',
        'date_demarrage' => 'date',
        'fait_projet' => 'date',
        'date_signature' => 'date',
        'etat' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot du modèle
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->numero_soumission)) {
                $model->numero_soumission = 'SOU-' . date('Y') . '-' . str_pad(static::max('id') + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Relations
     */
    public function guichet()
    {
        return $this->belongsTo(Guichet::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function historiques()
    {
        return $this->hasMany(SoumissionHistorique::class)
            ->where('etat', TypeEtat::ACTIF)
            ->orderBy('date_action', 'desc');
    }

    public function dernierHistorique()
    {
        return $this->hasOne(SoumissionHistorique::class)
            ->where('etat', TypeEtat::ACTIF)
            ->orderBy('date_action', 'desc');
    }

    /**
     * Vérifier si la soumission est active
     */
    public function isActif(): bool
    {
        return $this->etat === TypeEtat::ACTIF;
    }

    /**
     * Vérifier si la soumission est supprimée
     */
    public function isSupprime(): bool
    {
        return $this->etat === TypeEtat::SUPPRIME;
    }

    /**
     * Accesseur pour le statut label
     */
    public function getStatutLabelAttribute(): string
    {
        return StatutSoumission::getLabel($this->statut_soumission);
    }

    /**
     * Accesseur pour le badge de statut
     */
    public function getStatutBadgeAttribute(): string
    {
        return StatutSoumission::getBadge($this->statut_soumission);
    }

    /**
     * Accesseur pour l'icône du statut
     */
    public function getStatutIconAttribute(): string
    {
        return StatutSoumission::getIcon($this->statut_soumission);
    }

    /**
     * Accesseur pour la couleur du statut
     */
    public function getStatutColorAttribute(): string
    {
        return StatutSoumission::getColor($this->statut_soumission);
    }

    /**
     * Accesseur pour la progression
     */
    public function getProgressionAttribute(): int
    {
        return StatutSoumission::getProgress($this->statut_soumission);
    }

    /**
     * Accesseur pour le nom du guichet
     */
    public function getNomGuichetAttribute(): string
    {
        return $this->guichet ? $this->guichet->nom : '-';
    }

    /**
     * Accesseur pour le nom de la région
     */
    public function getNomRegionAttribute(): string
    {
        return $this->region ? $this->region->nom : '-';
    }

    /**
     * Accesseur pour le nom de la préfecture
     */
    public function getNomPrefectureAttribute(): string
    {
        return $this->prefecture ? $this->prefecture->nom : '-';
    }

    /**
     * Accesseur pour le nom de la commune
     */
    public function getNomCommuneAttribute(): string
    {
        return $this->commune ? $this->commune->nom : '-';
    }

    /**
     * Accesseur pour la date formatée
     */
    public function getDateSoumissionFormateeAttribute(): string
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    /**
     * Accesseur pour le dernier commentaire
     */
    public function getDernierCommentaireAttribute(): ?string
    {
        return $this->dernierHistorique ? $this->dernierHistorique->commentaire : null;
    }

    /**
     * Accesseur pour le statut du document
     */
    public function getDocStatutUrlAttribute(): ?string
    {
        return $this->doc_statut ? asset('storage/' . $this->doc_statut) : null;
    }

    /**
     * Accesseur pour l'attestation fiscale
     */
    public function getAttestationFiscalUrlAttribute(): ?string
    {
        return $this->attestation_fiscal ? asset('storage/' . $this->attestation_fiscal) : null;
    }

    /**
     * Accesseur pour l'autre document
     */
    public function getAutreDocumentUrlAttribute(): ?string
    {
        return $this->autre_document ? asset('storage/' . $this->autre_document) : null;
    }

    /**
     * Accesseur pour le document budget
     */
    public function getDocBudgetUrlAttribute(): ?string
    {
        return $this->doc_budget ? asset('storage/' . $this->doc_budget) : null;
    }
}
