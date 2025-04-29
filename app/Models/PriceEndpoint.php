<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\PriceEndpoint
 *
 * @property int $id
 * @property bool $active
 * @property string $slug
 * @property string $url
 * @property float|null $previous_price
 * @property float|null $current_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static Builder|PriceEndpoint active()
 * @method static Builder|PriceEndpoint newModelQuery()
 * @method static Builder|PriceEndpoint newQuery()
 * @method static Builder|PriceEndpoint query()
 * @method static Builder|PriceEndpoint whereActive($value)
 * @method static Builder|PriceEndpoint whereCreatedAt($value)
 * @method static Builder|PriceEndpoint whereCurrentPrice($value)
 * @method static Builder|PriceEndpoint whereId($value)
 * @method static Builder|PriceEndpoint wherePreviousPrice($value)
 * @method static Builder|PriceEndpoint whereSlug($value)
 * @method static Builder|PriceEndpoint whereUpdatedAt($value)
 * @method static Builder|PriceEndpoint whereUrl($value)
 * @mixin \Eloquent
 */
class PriceEndpoint extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'slug',
        'url',
        'previous_price',
        'current_price',
        'active',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'previous_price' => 'float',
        'current_price' => 'float',
        'active' => 'boolean',
    ];

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    /**
     * @param float|null $price
     * @return $this
     */
    public function updatePrice(?float $price): static
    {
        if (is_null($price)) {
            $this->update(['active' => false]);
        } else {
            $this->update(['current_price' => $price, 'previous_price' => $this->current_price]);
        }

        return $this;
    }
}
