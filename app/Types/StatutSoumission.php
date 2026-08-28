<?php

namespace App\Types;

/**
 * Liste des statuts pour les soumissions de projets
 *
 * @author pmazama@gmail.com
 * @copyright HAMZ-Eng 2022
 * @version 1
 */
class StatutSoumission
{
    const EN_ATTENTE = 1;
    const EN_COURS = 2;
    const APPROUVE = 3;
    const REJETE = 4;

    /**
     * Libellés des statuts
     */
    public static function labels(): array
    {
        return [
            self::EN_ATTENTE => 'En attente',
            self::EN_COURS => 'En cours',
            self::APPROUVE => 'Approuvé',
            self::REJETE => 'Rejeté',
        ];
    }

    /**
     * Couleurs des badges
     */
    public static function badges(): array
    {
        return [
            self::EN_ATTENTE => 'warning',
            self::EN_COURS => 'primary',
            self::APPROUVE => 'success',
            self::REJETE => 'danger',
        ];
    }

    /**
     * Icônes des statuts
     */
    public static function icons(): array
    {
        return [
            self::EN_ATTENTE => 'fa-clock',
            self::EN_COURS => 'fa-spinner',
            self::APPROUVE => 'fa-check-circle',
            self::REJETE => 'fa-times-circle',
        ];
    }

    /**
     * Obtenir le libellé d'un statut
     */
    public static function getLabel(int $statut): string
    {
        return self::labels()[$statut] ?? 'Inconnu';
    }

    /**
     * Obtenir la classe du badge
     */
    public static function getBadge(int $statut): string
    {
        return self::badges()[$statut] ?? 'secondary';
    }

    /**
     * Obtenir l'icône
     */
    public static function getIcon(int $statut): string
    {
        return self::icons()[$statut] ?? 'fa-question';
    }

    /**
     * Liste pour les selects
     */
    public static function list(): array
    {
        return self::labels();
    }

    /**
     * Vérifier si le statut est en attente
     */
    public static function isEnAttente(int $statut): bool
    {
        return $statut === self::EN_ATTENTE;
    }

    /**
     * Vérifier si le statut est en cours
     */
    public static function isEnCours(int $statut): bool
    {
        return $statut === self::EN_COURS;
    }

    /**
     * Vérifier si le statut est approuvé
     */
    public static function isApprouve(int $statut): bool
    {
        return $statut === self::APPROUVE;
    }

    /**
     * Vérifier si le statut est rejeté
     */
    public static function isRejete(int $statut): bool
    {
        return $statut === self::REJETE;
    }

    /**
     * Vérifier si le statut est final (terminé)
     */
    public static function isFinal(int $statut): bool
    {
        return in_array($statut, [self::APPROUVE, self::REJETE]);
    }

    /**
     * Vérifier si le statut est en cours de traitement
     */
    public static function isInProgress(int $statut): bool
    {
        return in_array($statut, [self::EN_ATTENTE, self::EN_COURS]);
    }

    /**
     * Statuts valides
     */
    public static function values(): array
    {
        return [
            self::EN_ATTENTE,
            self::EN_COURS,
            self::APPROUVE,
            self::REJETE,
        ];
    }

    /**
     * Vérifier si une valeur est valide
     */
    public static function isValid(int $statut): bool
    {
        return in_array($statut, self::values());
    }

    /**
     * Obtenir les couleurs pour l'affichage
     */
    public static function colors(): array
    {
        return [
            self::EN_ATTENTE => '#ffc107',
            self::EN_COURS => '#007bff',
            self::APPROUVE => '#28a745',
            self::REJETE => '#dc3545',
        ];
    }

    /**
     * Obtenir la prochaine étape du workflow
     */
    public static function getNextStep(int $statut): ?int
    {
        return match($statut) {
            self::EN_ATTENTE => self::EN_COURS,
            self::EN_COURS => self::APPROUVE,
            default => null,
        };
    }

    /**
     * Obtenir le libellé de la prochaine étape
     */
    public static function getNextStepLabel(int $statut): ?string
    {
        $next = self::getNextStep($statut);
        return $next ? self::getLabel($next) : null;
    }

    /**
     * Obtenir la classe CSS pour la progression
     */
    public static function getProgressClass(int $statut): string
    {
        return match($statut) {
            self::EN_ATTENTE => 'bg-warning',
            self::EN_COURS => 'bg-primary',
            self::APPROUVE => 'bg-success',
            self::REJETE => 'bg-danger',
            default => 'bg-secondary',
        };
    }

    /**
     * Obtenir le pourcentage de progression
     */
    public static function getProgress(int $statut): int
    {
        return match($statut) {
            self::EN_ATTENTE => 25,
            self::EN_COURS => 50,
            self::APPROUVE => 100,
            self::REJETE => 100,
            default => 0,
        };
    }

    /**
     * Obtenir les statuts pour le workflow
     */
    public static function getWorkflowSteps(): array
    {
        return [
            self::EN_ATTENTE => [
                'label' => 'En attente',
                'icon' => 'fa-clock',
                'badge' => 'warning',
            ],
            self::EN_COURS => [
                'label' => 'En cours d\'examen',
                'icon' => 'fa-spinner',
                'badge' => 'primary',
            ],
            self::APPROUVE => [
                'label' => 'Approuvé',
                'icon' => 'fa-check-circle',
                'badge' => 'success',
            ],
            self::REJETE => [
                'label' => 'Rejeté',
                'icon' => 'fa-times-circle',
                'badge' => 'danger',
            ],
        ];
    }
}
