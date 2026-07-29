<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'archived_at',
    ];

    protected $casts = [
        'archived_at' => 'datetime',
    ];

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function archive(): bool
    {
        return $this->update(['archived_at' => now()]);
    }

    public function isArchived(): bool
    {
        return $this->archived_at !== null;
    }

    public function scopeActive(Builder $query): void
    {
        $query->whereNull('archived_at');
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query
            ->when(
                $filters['search'] ?? null,
                fn ($q, $search) => $q->where('name', 'like', "%{$search}%")
            )
            ->when(
                $filters['status'] ?? null,
                fn ($q, $status) => match ($status) {
                    'active' => $q->whereNull('archived_at'),
                    'inactive' => $q->whereNotNull('archived_at'),
                    default => $q,
                }
            );
    }
}
