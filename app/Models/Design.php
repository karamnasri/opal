<?php

namespace App\Models;

use App\Casts\PriceCast;
use App\Enums\PrintTypeEnum;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

/**
 *
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $price
 * @property string|null $discounted_price
 * @property int $category_id
 * @property string|null $color
 * @property string|null $s3_file_url
 * @property string|null $preview_image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Design newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Design newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Design query()
 * @method static \Illuminate\Database\Eloquent\Builder|Design whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Design whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Design whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Design whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Design whereDiscountedPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Design whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Design wherePreviewImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Design wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Design whereS3FileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Design whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Design whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Design extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'discount_percentage',
        'color',
        'file_path',
        'image_path',
        'print_type',
    ];

    protected $appends = [
        'original_price',
        'final_price',
        'likers_count',
        'purchases_count',
        'image_url',
    ];

    protected $casts = [
        'price' => PriceCast::class,
        'discount_percentage' => 'integer',
        'color' => 'array',
        'print_type' => PrintTypeEnum::class,
    ];

    protected $hidden = ['file_path'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function likers(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function scopeIsLiker(Builder $query, User $user): Builder
    {
        return $query->whereHas('likers', fn($q) => $q->where('user_id', $user->id));
    }

    public function isLikedBy(User $user): bool
    {
        return $this->likers()->where('user_id', $user->id)->exists();
    }

    public function isRecentlyPurchasedBy(User $user): bool
    {
        return $user->purchases()
            ->where('design_id', $this->id)
            ->where('created_at', '>=', now()->subMonth())
            ->exists();
    }

    public function originalPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->price
        );
    }

    public function finalPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->hasDiscount() ? $this->price->applyDiscount($this->discount_percentage) : $this->price
        );
    }

    public function likersCount(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->likers_count ?? $this->likers()->count()
        );
    }

    public function purchasesCount(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->purchases_count ?? $this->purchases()->count()
        );
    }

    public function ImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => Storage::disk('public')->url($this->image_path)
        );
    }

    public function color(): Attribute
    {
        return Attribute::make(
            get: fn($value) => is_string($value) ? json_decode($value, true) : $value,
            set: fn($value) => json_encode($value),
        );
    }

    public function filePath(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes): ?string {
                $user = auth()->user();

                if (!$user || Gate::denies('canAccessFilePath', $this)) {
                    return null;
                }

                return $attributes['file_path'];
            },
        );
    }

    public function hasDiscount(): bool
    {
        return $this->discount_percentage > 0 && $this->discount_percentage < 100;
    }

    public function secureDownloadUrl(): ?string
    {
        $user = auth()->user();

        if (!$user || !$this->isRecentlyPurchasedBy($user)) {
            return null;
        }

        return URL::temporarySignedRoute(
            'design.download',
            now()->addMinutes(5),
            ['design' => $this->id]
        );
    }
}
