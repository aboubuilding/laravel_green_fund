<?php

namespace App\Models;

use App\Types\TypeEtat;
use App\Types\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'role_id',
        'nom',
        'email',
        'telephone',
        'avatar',
        'email_verifie_le',
        'mot_de_passe',
        'est_actif',
        'derniere_connexion_le',
        'etat',
        'remember_token',
    ];

    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    protected $casts = [
        'role_id' => 'integer',
        'etat' => 'integer',
        'est_actif' => 'boolean',
        'email_verifie_le' => 'datetime',
        'derniere_connexion_le' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the password for the user.
     */
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    /**
     * Get the name of the unique identifier for the user.
     */
    public function getAuthIdentifierName()
    {
        return 'email';
    }

    /**
     * Get the unique identifier for the user.
     */
    public function getAuthIdentifier()
    {
        return $this->email;
    }

    /**
     * Vérifier si l'utilisateur peut se connecter
     */
    public function canLogin(): bool
    {
        return $this->est_actif && $this->etat === TypeEtat::ACTIF;
    }

    /**
     * Vérifier si l'utilisateur est actif
     */
    public function isActif(): bool
    {
        return $this->etat === TypeEtat::ACTIF;
    }

    /**
     * Vérifier si l'utilisateur est supprimé
     */
    public function isSupprime(): bool
    {
        return $this->etat === TypeEtat::SUPPRIME;
    }

    /**
     * Vérifier si l'utilisateur est administrateur
     */
    public function isAdmin(): bool
    {
        return $this->role_id === Role::ADMIN;
    }

    /**
     * Vérifier si l'utilisateur est un simple utilisateur
     */
    public function isUser(): bool
    {
        return $this->role_id === Role::USER;
    }

    /**
     * Mettre à jour la date de dernière connexion
     */
    public function updateLastLogin(): bool
    {
        return $this->update(['derniere_connexion_le' => now()]);
    }

    /**
     * Vérifier si l'email est vérifié
     */
    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verifie_le);
    }

    /**
     * Marquer l'email comme vérifié
     */
    public function markEmailAsVerified(): bool
    {
        return $this->update(['email_verifie_le' => now()]);
    }

    /**
     * Accesseur pour le nom complet
     */
    public function getNomCompletAttribute(): string
    {
        return $this->nom;
    }

    /**
     * Accesseur pour le libellé du rôle
     */
    public function getRoleLabelAttribute(): string
    {
        return Role::getLabel($this->role_id);
    }

    /**
     * Accesseur pour le badge du rôle
     */
    public function getRoleBadgeAttribute(): string
    {
        return Role::getBadge($this->role_id);
    }

    /**
     * Accesseur pour l'icône du rôle
     */
    public function getRoleIconAttribute(): string
    {
        return Role::getIcon($this->role_id);
    }
}
