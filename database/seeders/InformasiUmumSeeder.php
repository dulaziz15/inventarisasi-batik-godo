<?php

namespace Database\Seeders;

use App\Models\InformasiUmum;
use Illuminate\Database\Seeder;

class InformasiUmumSeeder extends Seeder
{
    public function run(): void
    {
        InformasiUmum::updateOrCreate([
            'key' => 'tentang',
        ], [
            'content' => "Batik Banyuwangi tumbuh dari tradisi Kerajaan Blambangan. Warna-warnanya cenderung berani seperti merah, kuning, dan hijau. Filosofinya menekankan persatuan, kerja keras, serta kedekatan masyarakat dengan alam dan adat.",
        ]);

        InformasiUmum::updateOrCreate([
            'key' => 'kontak',
        ], [
            'content' => "Batik Godo\nAlamat: Banyuwangi, Jawa Timur\nMedia sosial: silakan isi tautan resmi UMKM jika tersedia.",
        ]);
    }
}