<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    //-------------------------------------------Relationships
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
    //-------------------------------------------------------
    public function rating()
    {
        return round($this->reviews->avg("rating"), 1);
    }
    public function getImagesList()
    {
        // TODO Images List
        return $this->images->map(fn($image) => $image->url);
    }
    public function scopeActive(Builder $query)
    {
        return $query->where("is_active", "=", 1);
    }

    public function getCreatedAtAttribute($value)
    {
        $createdAt = Carbon::parse($value);        
        return $createdAt->format('Y:m:d H:i:s');
    }
}
