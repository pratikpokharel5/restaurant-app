<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_price',
        'status',
        'notes',
    ];

    public const STATUS_PENDING = 'pending';

    public const STATUS_PREPARING = 'preparing';

    public const STATUS_ON_THE_WAY = 'on_the_way';

    public const STATUS_DELIVERED = 'delivered';

    public const STATUS_CANCELLED = 'cancelled';

    public const TRANSITIONS = [
        self::STATUS_PENDING => [
            self::STATUS_PREPARING,
            self::STATUS_CANCELLED,
        ],
        self::STATUS_PREPARING => [
            self::STATUS_ON_THE_WAY,
            self::STATUS_CANCELLED,
        ],
        self::STATUS_ON_THE_WAY => [
            self::STATUS_DELIVERED,
            self::STATUS_CANCELLED,
        ],
        self::STATUS_DELIVERED => [],
        self::STATUS_CANCELLED => [],
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public static function statuses(): array
    {
        return array_keys(self::statusLabels());
    }

    public static function statusLabels(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PREPARING => 'Preparing',
            self::STATUS_ON_THE_WAY => 'On the Way',
            self::STATUS_DELIVERED => 'Delivered',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    public function canTransitionTo(string $status): bool
    {
        return in_array(
            $status,
            self::TRANSITIONS[$this->status] ?? [],
            true
        );
    }

    public function nextStatuses(): array
    {
        return self::TRANSITIONS[$this->status] ?? [];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->whereHas('customer', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            });
        });

        $query->when(
            ($filters['status'] ?? null) && in_array($filters['status'], self::statuses(), true),
            fn ($query) => $query->where('status', $filters['status'])
        )
            ->when(
                $filters['order_date'] ?? null,
                fn ($query, $orderDate) => $query->whereDate('created_at', $orderDate)
            );
    }
}
