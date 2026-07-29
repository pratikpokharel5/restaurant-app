<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'archived_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';

    public const ROLE_STAFF = 'staff';

    public static function roles(): array
    {
        return [
            self::ROLE_ADMIN,
            self::ROLE_STAFF,
        ];
    }

    public function archive(): bool
    {
        return $this->update(['archived_at' => now()]);
    }

    public function restoreFromArchive(): bool
    {
        return $this->update(['archived_at' => null]);
    }

    public function isArchived(): bool
    {
        return $this->archived_at !== null;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
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
                fn ($query, $search) => $query
                    ->where(function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
            )
            ->when(
                $filters['status'] ?? null,
                fn ($query, $status) => match ($status) {
                    'active' => $query->whereNull('archived_at'),
                    'archived' => $query->whereNotNull('archived_at'),
                    default => $query,
                }
            );
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'archived_at' => 'datetime',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
