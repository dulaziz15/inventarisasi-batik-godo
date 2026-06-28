<?php

namespace Database\Seeders;

use App\Models\Motif;
use Illuminate\Database\Seeder;

class MotifSeeder extends Seeder
{
    public function run(): void
    {
        $placeholderImage = 'images/motif-placeholder.svg';
        $placeholderMeaning = 'Secara umum membawa semangat persatuan dari Kerajaan Blambangan. Pendalaman spesifik masih diperlukan.';

        $motifs = [
            ['name' => 'Gajah Oling', 'category' => 'sakral', 'philosophical_meaning' => 'Pengingat kepada Tuhan dan tuntunan hidup yang luhur.', 'verification_status' => 'terverifikasi'],
            ['name' => 'Kangkung Setingkes', 'category' => 'umum', 'philosophical_meaning' => 'Menunjukkan kebersamaan dan ikatan yang saling menguatkan.', 'verification_status' => 'terverifikasi'],
            ['name' => 'Paras Gempal', 'category' => 'umum', 'philosophical_meaning' => 'Melambangkan kekuatan, kerja keras, dan keteguhan hati.', 'verification_status' => 'terverifikasi'],
            ['name' => 'Gedekan', 'category' => 'umum', 'philosophical_meaning' => 'Menegaskan semangat saling melengkapi dalam kehidupan bersama.', 'verification_status' => 'terverifikasi'],
            ['name' => 'Joyo Binangun', 'category' => 'umum'],
            ['name' => 'Blarak Sempal', 'category' => 'umum'],
            ['name' => 'Sekar Jagad', 'category' => 'umum'],
            ['name' => 'Sembruk Cacing', 'category' => 'umum'],
            ['name' => 'Totogan', 'category' => 'umum'],
            ['name' => 'Bambang Cuwut', 'category' => 'umum'],
            ['name' => 'Alas Kobong', 'category' => 'umum'],
            ['name' => 'Beras Kutah', 'category' => 'umum'],
            ['name' => 'Kopi Pecah', 'category' => 'umum'],
            ['name' => 'Ukel', 'category' => 'umum'],
            ['name' => 'Galaran', 'category' => 'umum'],
            ['name' => 'Latar Putih', 'category' => 'umum'],
            ['name' => 'Yang Sengk', 'category' => 'umum'],
            ['name' => 'Jajang Sebarong', 'category' => 'umum'],
            ['name' => 'Kopi Wungkul', 'category' => 'umum'],
            ['name' => 'Wader Kesit', 'category' => 'umum'],
            ['name' => 'Sisik', 'category' => 'umum'],
            ['name' => 'Opak Gambir', 'category' => 'umum'],
        ];

        foreach ($motifs as $motifData) {
            Motif::updateOrCreate(
                ['name' => $motifData['name']],
                [
                    'category' => $motifData['category'],
                    'philosophical_meaning' => $motifData['philosophical_meaning'] ?? $placeholderMeaning,
                    'history' => $motifData['history'] ?? null,
                    'visual_description' => $motifData['visual_description'] ?? null,
                    'technique' => $motifData['technique'] ?? 'tulis',
                    'usage_rule' => $motifData['usage_rule'] ?? 'umum',
                    'knowledge_source' => $motifData['knowledge_source'] ?? 'Hasil inventarisasi tahap 2 Batik Godo',
                    'verification_status' => $motifData['verification_status'] ?? 'terdata',
                    'main_image' => $placeholderImage,
                    'thumbnail_image' => $placeholderImage,
                ]
            );
        }
    }
}