<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MotifGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'motif_id',
        'image_path',
    ];

    public function motif()
    {
        return $this->belongsTo(Motif::class);
    }

    public function imageUrl(): string
    {
        if ($this->image_path && Storage::disk('public')->exists($this->image_path)) {
            return Storage::disk('public')->url($this->image_path);
        }

        return asset($this->image_path ?: 'images/motif-placeholder.svg');
    }
}