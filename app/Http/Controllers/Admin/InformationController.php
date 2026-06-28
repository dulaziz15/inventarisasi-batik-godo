<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiUmum;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function edit()
    {
        return view('admin.information.edit', [
            'tentang' => InformasiUmum::firstOrNew(['key' => 'tentang']),
            'kontak' => InformasiUmum::firstOrNew(['key' => 'kontak']),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'tentang' => ['required', 'string'],
            'kontak' => ['required', 'string'],
        ], [
            'tentang.required' => 'Konten tentang wajib diisi.',
            'kontak.required' => 'Konten kontak wajib diisi.',
        ]);

        InformasiUmum::updateOrCreate(['key' => 'tentang'], ['content' => $data['tentang']]);
        InformasiUmum::updateOrCreate(['key' => 'kontak'], ['content' => $data['kontak']]);

        return back()->with('success', 'Informasi umum berhasil diperbarui.');
    }
}