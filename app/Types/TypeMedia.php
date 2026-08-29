<?php

namespace App\Types;

class TypeMedia
{
    const PHOTO = 1;
    const VIDEO = 2;

    public static function labels(): array
    {
        return [
            self::PHOTO => 'Photo',
            self::VIDEO => 'Vidéo',
        ];
    }

    public static function badges(): array
    {
        return [
            self::PHOTO => 'primary',
            self::VIDEO => 'danger',
        ];
    }

    public static function icons(): array
    {
        return [
            self::PHOTO => 'fa-image',
            self::VIDEO => 'fa-video',
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
        return self::icons()[$type] ?? 'fa-file';
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
