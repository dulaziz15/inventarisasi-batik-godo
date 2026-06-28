<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Motif extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'sakral' => 'Sakral',
        'umum' => 'Umum',
        'sakral_pengantin' => 'Sakral Pengantin',
    ];

    public const TECHNIQUES = [
        'tulis' => 'Tulis',
        'cap' => 'Cap',
        'combination' => 'Kombinasi',
    ];

    public const USAGE_RULES = [
        'umum' => 'Umum',
        'sakral_pengantin' => 'Sakral Pengantin',
        'terbatas' => 'Terbatas',
    ];

    public const VERIFICATION_STATUSES = [
        'terverifikasi' => 'Terverifikasi',
        'terdata' => 'Terdata',
        'perlu_pendalaman' => 'Perlu Pendalaman',
    ];

    protected $fillable = [
        'name',
        'category',
        'philosophical_meaning',
        'history',
        'visual_description',
        'technique',
        'usage_rule',
        'knowledge_source',
        'verification_status',
        'main_image',
        'thumbnail_image',
    ];

    public function galleries()
    {
        return $this->hasMany(MotifGallery::class);
    }

    public function scopeSearch($query, ?string $keyword)
    {
        return $keyword ? $query->where(function ($builder) use ($keyword): void {
            $builder->where('name', 'like', '%'.$keyword.'%')
                ->orWhere('philosophical_meaning', 'like', '%'.$keyword.'%');
        }) : $query;
    }

    public function imageUrl(): string
    {
        return $this->resolveAssetUrl($this->main_image);
    }

    public function thumbnailUrl(): string
    {
        return $this->resolveAssetUrl($this->thumbnail_image ?: $this->main_image);
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst(str_replace('_', ' ', (string) $this->category));
    }

    public function techniqueLabel(): string
    {
        return self::TECHNIQUES[$this->technique] ?? ucfirst((string) $this->technique);
    }

    public function usageRuleLabel(): string
    {
        return self::USAGE_RULES[$this->usage_rule] ?? ucfirst(str_replace('_', ' ', (string) $this->usage_rule));
    }

    public function verificationLabel(): string
    {
        return self::VERIFICATION_STATUSES[$this->verification_status] ?? ucfirst(str_replace('_', ' ', (string) $this->verification_status));
    }

    public function isSakral(): bool
    {
        return $this->category === 'sakral';
    }

    protected function resolveAssetUrl(?string $path): string
    {
        if (! $path) {
            return asset('images/motif-placeholder.svg');
        }

        if (Storage::disk('public')->exists($path)) {
            return asset('storage/'.$path);
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset($path);
    }
}