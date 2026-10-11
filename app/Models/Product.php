<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'short_description', 'description',
        'price', 'old_price', 'stock', 'image', 'is_featured', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'old_price' => 'integer',
            'stock' => 'integer',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            if (blank($product->slug) || $product->isDirty('name')) {
                $base = Str::slug($product->name) ?: 'produit';
                $slug = $base;
                $i = 2;
                while (static::where('slug', $slug)->when($product->id, fn ($q) => $q->where('id', '!=', $product->id))->exists()) {
                    $slug = $base.'-'.$i++;
                }
                $product->slug = $slug;
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public static function money(?int $amount): string
    {
        return number_format((int) $amount, 0, ',', ' ').' '.config('guinux.currency');
    }

    public function getFormattedPriceAttribute(): string
    {
        return static::money($this->price);
    }

    public function getFormattedOldPriceAttribute(): ?string
    {
        return $this->old_price ? static::money($this->old_price) : null;
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset('uploads/products/'.$this->image) : asset('images/placeholder.svg');
    }

    public function getDiscountPercentAttribute(): ?int
    {
        if (! $this->old_price || $this->old_price <= $this->price) {
            return null;
        }

        return (int) round(100 - ($this->price * 100 / $this->old_price));
    }

    public function getInStockAttribute(): bool
    {
        return $this->stock > 0;
    }
}
