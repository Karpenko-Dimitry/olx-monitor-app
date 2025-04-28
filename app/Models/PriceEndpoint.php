<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PriceEndpoint
 *
 * @property int $id
 * @property string $slug
 * @property string $url
 * @property float|null $previous_price
 * @property float|null $current_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|PriceEndpoint newModelQuery()
 * @method static Builder|PriceEndpoint newQuery()
 * @method static Builder|PriceEndpoint query()
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
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'previous_price' => 'float',
        'current_price' => 'float',
    ];

    public function makeNew()
    {
        return new static();
    }
}
