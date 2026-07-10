<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file_path',
        'file_type',
        'album_name',
        'is_featured',
        'order',
        'description',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

    // Get file URL
    public function getFileUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    // Get file type icon
    public function getFileIconAttribute()
    {
        if ($this->file_type === 'image') {
            return 'fa fa-image';
        }
        return 'fa fa-video-camera';
    }

    // Get status badge
    public function getFeaturedBadgeAttribute()
    {
        return $this->is_featured 
            ? '<span class="badge badge-success">Featured</span>' 
            : '<span class="badge badge-secondary">Normal</span>';
    }
}