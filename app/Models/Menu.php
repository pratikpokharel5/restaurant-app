<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'is_available',
        'image_url',
        'category_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function archive(): bool
    {
        return $this->update(['is_available' => false]);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query
            ->when(
                $filters['search'] ?? null,
                fn ($q, $search) => $q->where('name', 'like', "%{$search}%")
            )
            ->when(
                isset($filters['is_available']) && $filters['is_available'] !== '',
                fn ($q) => $q->where(
                    'is_available',
                    filter_var($filters['is_available'], FILTER_VALIDATE_BOOLEAN)
                )
            );
    }
}
