<?php

namespace App\Models;

use App\Casts\PriceCast;
use App\Enums\PrintTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'category_id',
        'color',
        's3_file_url',
        'preview_image',
        'print_type',
    ];

    protected $casts = [
        'price' => PriceCast::class,
        'discount_percentage' => 'integer',
        'color' => 'array',
        'print_type' => PrintTypeEnum::class
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function likedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function isLikedByUser(?int $userId): bool
    {
        if (!$userId) {
            return false;
        }

        return $this->likedByUsers()->where('user_id', $userId)->exists();
    }

    public function discountPrice()
    {
        $discountedPrice = is_null($this->discount_percentage)
            ? $this->price
            : $this->price * ((100 - $this->discount_percentage) / 100);

        return (float) number_format($discountedPrice, 2);
    }
}
