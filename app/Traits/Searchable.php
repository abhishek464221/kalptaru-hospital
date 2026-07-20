<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public function scopeSearch(Builder $query, $search, array $columns)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($q) use ($search, $columns) {

            foreach ($columns as $column) {

                $q->orWhere($column, 'LIKE', "%{$search}%");

            }

        });
    }
}