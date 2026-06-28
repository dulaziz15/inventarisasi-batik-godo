<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Motif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MotifController extends Controller
{
    public function index(Request $request)
    {
        $motifs = Motif::query()
            ->search($request->input('q'))
            ->when($request->filled('status'), fn ($query) => $query->where('verification_status', $request->input('status')))
            ->when($request->filled('kategori'), fn ($query) => $query->where('category', $request->input('kategori')))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.motifs.index', [
            'motifs' => $motifs,
            'categories' => Motif::CATEGORIES,
            'statuses' => Motif::VERIFICATION_STATUSES,
        ]);
    }

    public function create()
    {
        return view('admin.motifs.create', [
            'motif' => new Motif(),
            'categories' => Motif::CATEGORIES,
            'techniques' => Motif::TECHNIQUES,
            'usageRules' => Motif::USAGE_RULES,
            'statuses' => Motif::VERIFICATION_STATUSES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateMotif($request);

        $data['main_image'] = $this->storeImage($request->file('main_image'));
        $data['thumbnail_image'] = $this->makeThumbnail($data['main_image']);

        $motif = Motif::create($data);

        $this->storeGalleryImages($motif, $request);
        $this->logAction('create', $motif, 'Menambah motif '.$motif->name.'.');

        return redirect()->route('admin.motifs.index')->with('success', 'Motif berhasil ditambahkan.');
    }

    public function edit(Motif $motif)
    {
        return view('admin.motifs.edit', [
            'motif' => $motif,
            'categories' => Motif::CATEGORIES,
            'techniques' => Motif::TECHNIQUES,
            'usageRules' => Motif::USAGE_RULES,
            'statuses' => Motif::VERIFICATION_STATUSES,
        ]);
    }

    public function update(Request $request, Motif $motif)
    {
        $data = $this->validateMotif($request, $motif->id);

        if ($motif->category === 'sakral' && $data['category'] !== 'sakral' && ! $request->boolean('confirm_sakral_change')) {
            return back()->withErrors([
                'confirm_sakral_change' => 'Perubahan status sakral memerlukan konfirmasi tambahan.',
            ])->withInput();
        }

        if ($request->hasFile('main_image')) {
            $this->deleteStoredFile($motif->main_image);
            $this->deleteStoredFile($motif->thumbnail_image);
            $data['main_image'] = $this->storeImage($request->file('main_image'));
            $data['thumbnail_image'] = $this->makeThumbnail($data['main_image']);
        } else {
            unset($data['main_image'], $data['thumbnail_image']);
        }

        $motif->update($data);
        $this->storeGalleryImages($motif, $request);
        $this->logAction('update', $motif, 'Memperbarui motif '.$motif->name.'.');

        return redirect()->route('admin.motifs.index')->with('success', 'Motif berhasil diperbarui.');
    }

    public function destroy(Motif $motif)
    {
        $this->deleteStoredFile($motif->main_image);
        $this->deleteStoredFile($motif->thumbnail_image);

        foreach ($motif->galleries as $gallery) {
            $this->deleteStoredFile($gallery->image_path);
            $gallery->delete();
        }

        $name = $motif->name;
        $motif->delete();
        $this->logAction('delete', $motif, 'Menghapus motif '.$name.'.');

        return redirect()->route('admin.motifs.index')->with('success', 'Motif berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $motifs = Motif::query()
            ->search($request->input('q'))
            ->when($request->filled('status'), fn ($query) => $query->where('verification_status', $request->input('status')))
            ->when($request->filled('kategori'), fn ($query) => $query->where('category', $request->input('kategori')))
            ->latest()
            ->get();

        $filename = 'motif-batik-banyuwangi-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($motifs): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nama', 'Kategori', 'Makna Filosofis', 'Teknik', 'Aturan Penggunaan', 'Sumber', 'Status Verifikasi']);

            foreach ($motifs as $motif) {
                fputcsv($handle, [
                    $motif->name,
                    $motif->categoryLabel(),
                    $motif->philosophical_meaning,
                    $motif->techniqueLabel(),
                    $motif->usageRuleLabel(),
                    $motif->knowledge_source,
                    $motif->verificationLabel(),
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    protected function validateMotif(Request $request, ?int $motifId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('motifs', 'name')->ignore($motifId)],
            'category' => ['required', Rule::in(array_keys(Motif::CATEGORIES))],
            'philosophical_meaning' => ['required', 'string'],
            'history' => ['nullable', 'string'],
            'visual_description' => ['nullable', 'string'],
            'technique' => ['required', Rule::in(array_keys(Motif::TECHNIQUES))],
            'usage_rule' => ['required', Rule::in(array_keys(Motif::USAGE_RULES))],
            'knowledge_source' => ['required', 'string', 'max:255'],
            'verification_status' => ['required', Rule::in(array_keys(Motif::VERIFICATION_STATUSES))],
            'main_image' => [$motifId ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'confirm_sakral_change' => ['nullable', 'accepted'],
        ], [
            'name.required' => 'Nama motif wajib diisi.',
            'name.unique' => 'Nama motif sudah digunakan.',
            'category.required' => 'Kategori motif wajib dipilih.',
            'philosophical_meaning.required' => 'Makna filosofis wajib diisi.',
            'technique.required' => 'Teknik pembuatan wajib dipilih.',
            'usage_rule.required' => 'Aturan penggunaan wajib dipilih.',
            'knowledge_source.required' => 'Sumber pengetahuan wajib diisi.',
            'verification_status.required' => 'Status verifikasi wajib dipilih.',
            'main_image.required' => 'Gambar utama wajib diunggah.',
            'main_image.image' => 'File gambar harus berupa JPG atau PNG.',
            'main_image.max' => 'Ukuran gambar maksimal 2MB.',
            'gallery_images.*.image' => 'Galeri tambahan harus berupa file gambar.',
        ]);
    }

    protected function storeImage($file): ?string
    {
        if (! $file) {
            return null;
        }

        return $file->store('motifs/main', 'public');
    }

    protected function makeThumbnail(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        $sourcePath = storage_path('app/public/'.$path);
        if (! is_file($sourcePath)) {
            return $path;
        }

        $thumbnailPath = preg_replace('#^motifs/main/#', 'motifs/thumbs/', $path);
        $targetPath = storage_path('app/public/'.$thumbnailPath);
        @mkdir(dirname($targetPath), 0775, true);

        $mime = mime_content_type($sourcePath);
        if ($mime === 'image/png' && function_exists('imagecreatefrompng')) {
            $sourceImage = imagecreatefrompng($sourcePath);
            $this->resizeAndSave($sourceImage, $targetPath, 'png');
            imagedestroy($sourceImage);

            return $thumbnailPath;
        }

        if (in_array($mime, ['image/jpeg', 'image/jpg'], true) && function_exists('imagecreatefromjpeg')) {
            $sourceImage = imagecreatefromjpeg($sourcePath);
            $this->resizeAndSave($sourceImage, $targetPath, 'jpeg');
            imagedestroy($sourceImage);

            return $thumbnailPath;
        }

        return $path;
    }

    protected function resizeAndSave($sourceImage, string $targetPath, string $type): void
    {
        $width = imagesx($sourceImage);
        $height = imagesy($sourceImage);
        $targetWidth = 640;
        $targetHeight = (int) round(($height / $width) * $targetWidth);
        $thumb = imagecreatetruecolor($targetWidth, $targetHeight);

        if ($type === 'png') {
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
        }

        imagecopyresampled($thumb, $sourceImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

        if ($type === 'png') {
            imagepng($thumb, $targetPath, 6);
        } else {
            imagejpeg($thumb, $targetPath, 85);
        }

        imagedestroy($thumb);
    }

    protected function deleteStoredFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    protected function storeGalleryImages(Motif $motif, Request $request): void
    {
        foreach ($request->file('gallery_images', []) as $file) {
            $path = $file->store('motifs/gallery', 'public');
            $motif->galleries()->create(['image_path' => $path]);
        }
    }

    protected function logAction(string $action, Motif $motif, string $description): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'subject_type' => Motif::class,
            'subject_id' => $motif->id,
            'description' => $description,
        ]);
    }
}