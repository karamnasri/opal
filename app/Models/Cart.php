<?php

namespace App\Models;

use App\ValueObjects\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status'];

    protected $appends = [
        'total_price_before',
        'total_price_after',
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function totalPriceBefore(): Attribute
    {
        return Attribute::make(
            get: fn() => new Money(
                $this->items->sum(fn($item) => $item->design->original_price->raw())
            )
        );
    }

    public function totalPriceAfter(): Attribute
    {
        return Attribute::make(
            get: fn() => new Money(
                $this->items->sum(fn($item) => $item->design->final_price->raw())
            )
        );
    }

    public function unpurchasedItemsFor(User $user): array
    {
        $ownedDesignIds = $user->purchases()
            ->where('created_at', '>=', now()->subMonth())
            ->pluck('design_id')
            ->flip();

        return $this->items
            ->reject(fn($item) => $ownedDesignIds->has($item->design_id))
            ->values()
            ->all();
    }

    public function checkout(?array $items = null): void
    {
        $items = $items ?? $this->items;
        foreach ($items as $item) {
            Purchase::create([
                'user_id'   => $this->user_id,
                'design_id' => $item->design_id,
            ]);
        }

        $this->delete();
    }
}
