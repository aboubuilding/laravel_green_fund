<?php

namespace App\Types;

class TypeEvenement
{
    const ATELIER = 1;
    const CONFERENCE = 2;
    const FORMATION = 3;
    const SEMINAIRE = 4;
    const WEBINAIRE = 5;

    public static function labels(): array
    {
        return [
            self::ATELIER => 'Atelier',
            self::CONFERENCE => 'Conférence',
            self::FORMATION => 'Formation',
            self::SEMINAIRE => 'Séminaire',
            self::WEBINAIRE => 'Webinaire',
        ];
    }

    public static function badges(): array
    {
        return [
            self::ATELIER => 'primary',
            self::CONFERENCE => 'info',
            self::FORMATION => 'success',
            self::SEMINAIRE => 'warning',
            self::WEBINAIRE => 'purple',
        ];
    }

    public static function icons(): array
    {
        return [
            self::ATELIER => 'fa-users-cog',
            self::CONFERENCE => 'fa-microphone',
            self::FORMATION => 'fa-chalkboard-teacher',
            self::SEMINAIRE => 'fa-users',
            self::WEBINAIRE => 'fa-laptop',
        ];
    }

    public static function colors(): array
    {
        return [
            self::ATELIER => '#007bff',
            self::CONFERENCE => '#17a2b8',
            self::FORMATION => '#28a745',
            self::SEMINAIRE => '#ffc107',
            self::WEBINAIRE => '#6f42c1',
        ];
    }

    public static function getLabel(int $type): string
    {
        return self::labels()[$type] ?? 'Inconnu';
    }

    public static function getBadge(int $type): string
    {
        return self::badges()[$type] ?? 'secondary';
    }

    public static function getIcon(int $type): string
    {
        return self::icons()[$type] ?? 'fa-calendar';
    }

    public static function getColor(int $type): string
    {
        return self::colors()[$type] ?? '#6c757d';
    }

    public static function values(): array
    {
        return array_keys(self::labels());
    }

    public static function list(): array
    {
        return self::labels();
    }
}
