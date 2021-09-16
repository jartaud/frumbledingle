<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['price_dsp'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getPriceDspAttribute()
    {
        if (!$this->price) {
            return '$ 0.00';
        }
        
        return '$ ' . number_format($this->attributes['price'], 2);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['location'] ?? null, function ($query, $locationId) {
            $query->whereHas('location', function ($location) use ($locationId) {
                $location->where('id', $locationId);
            });
        });
    }
}
