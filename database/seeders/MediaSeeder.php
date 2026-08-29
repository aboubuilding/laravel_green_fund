<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Types\TypeMedia;
use App\Types\TypeEtat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class MediaSeeder extends Seeder
{
    public function run(): void
    {
        // S'assurer que les dossiers existent
        Storage::disk('public')->makeDirectory('media');
        Storage::disk('public')->makeDirectory('media/thumbs');

        $media = [
            [
                'url' => 'media/photo1.jpg',
                'miniature' => 'media/thumbs/photo1_thumb.jpg',
                'type_media' => TypeMedia::PHOTO,
                'description' => 'Cérémonie de lancement du programme Green Togo',
                'date' => '2025-01-15',
            ],
            [
                'url' => 'media/photo2.jpg',
                'miniature' => 'media/thumbs/photo2_thumb.jpg',
                'type_media' => TypeMedia::PHOTO,
                'description' => 'Atelier de formation des porteurs de projets',
                'date' => '2025-02-10',
            ],
            [
                'url' => 'media/photo3.jpg',
                'miniature' => 'media/thumbs/photo3_thumb.jpg',
                'type_media' => TypeMedia::PHOTO,
                'description' => 'Visite de terrain du projet solaire de Kpalimé',
                'date' => '2025-03-05',
            ],
            [
                'url' => 'media/photo4.jpg',
                'miniature' => 'media/thumbs/photo4_thumb.jpg',
                'type_media' => TypeMedia::PHOTO,
                'description' => 'Signature de convention de partenariat',
                'date' => '2025-03-20',
            ],
            [
                'url' => 'media/photo5.jpg',
                'miniature' => 'media/thumbs/photo5_thumb.jpg',
                'type_media' => TypeMedia::PHOTO,
                'description' => 'Remise des prix aux meilleurs projets 2024',
                'date' => '2025-01-30',
            ],
            [
                'url' => 'media/video1.mp4',
                'miniature' => 'media/video-placeholder.jpg',
                'type_media' => TypeMedia::VIDEO,
                'description' => 'Présentation de TogoGreenFund - Vidéo institutionnelle',
                'date' => '2025-01-10',
            ],
            [
                'url' => 'media/video2.mp4',
                'miniature' => 'media/video-placeholder.jpg',
                'type_media' => TypeMedia::VIDEO,
                'description' => 'Témoignage d\'un bénéficiaire du projet agroforesterie',
                'date' => '2025-02-25',
            ],
            [
                'url' => 'media/video3.mp4',
                'miniature' => 'media/video-placeholder.jpg',
                'type_media' => TypeMedia::VIDEO,
                'description' => 'Conférence de presse - Lancement phase 3',
                'date' => '2025-03-15',
            ],
        ];

        foreach ($media as $item) {
            Media::updateOrCreate(
                ['url' => $item['url']],
                [
                    'miniature' => $item['miniature'],
                    'type_media' => $item['type_media'],
                    'description' => $item['description'],
                    'date' => $item['date'],
                    'etat' => TypeEtat::ACTIF,
                ]
            );
        }

        // Créer des fichiers vides pour les démonstrations
        $files = [
            'media/photo1.jpg' => 'Photo 1 - Cérémonie de lancement',
            'media/photo2.jpg' => 'Photo 2 - Atelier de formation',
            'media/photo3.jpg' => 'Photo 3 - Visite de terrain Kpalimé',
            'media/photo4.jpg' => 'Photo 4 - Signature de partenariat',
            'media/photo5.jpg' => 'Photo 5 - Remise des prix',
            'media/video1.mp4' => 'Vidéo 1 - Présentation institutionnelle',
            'media/video2.mp4' => 'Vidéo 2 - Témoignage bénéficiaire',
            'media/video3.mp4' => 'Vidéo 3 - Conférence de presse',
            'media/thumbs/photo1_thumb.jpg' => 'Thumb 1',
            'media/thumbs/photo2_thumb.jpg' => 'Thumb 2',
            'media/thumbs/photo3_thumb.jpg' => 'Thumb 3',
            'media/thumbs/photo4_thumb.jpg' => 'Thumb 4',
            'media/thumbs/photo5_thumb.jpg' => 'Thumb 5',
            'media/video-placeholder.jpg' => 'Video placeholder',
        ];

        foreach ($files as $path => $content) {
            $fullPath = storage_path('app/public/' . $path);
            $dir = dirname($fullPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            if (!file_exists($fullPath)) {
                file_put_contents($fullPath, $content);
            }
        }
    }
}
