<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category',
        'tags',
        'status',
        'published_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'published_at' => 'date',
        'user_id' => 'integer',
    ];

    // Relationship with author (user)
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Accessor for author name
    public function getAuthorNameAttribute()
    {
        return $this->author ? $this->author->name : 'Unknown';
    }

    // Boot method to auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });

        static::updating(function ($blog) {
            if ($blog->isDirty('title') && !$blog->isDirty('slug')) {
                $blog->slug = Str::slug($blog->title);
            }
        });
    }

    // Get status badge
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'draft' => 'badge-secondary',
            'published' => 'badge-success',
            'archived' => 'badge-danger',
        ];
        return '<span class="badge ' . ($colors[$this->status] ?? 'badge-secondary') . '">' . ucfirst($this->status) . '</span>';
    }

    // Get tags as string
    public function getTagsStringAttribute()
    {
        return $this->tags ? implode(', ', $this->tags) : '';
    }

    // Scope for published posts
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    // Scope for drafts
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }
}