<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'status' => 'boolean',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->whereHas('order.customer', function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            });
        })
            ->when(
                isset($filters['status']) && in_array($filters['status'], ['0', '1'], true),
                fn ($query) => $query->where('status', (bool) $filters['status'])
            )
            ->when(
                $filters['payment_date'] ?? null,
                fn ($query, $paymentDate) => $query->whereDate('created_at', $paymentDate)
            );
    }
}
