<?php

namespace App\Models;
use App\Traits\Searchable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['name', 'slug', 'description'];

    // Relation with users (optional)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}