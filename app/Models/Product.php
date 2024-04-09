<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name", "description", "price", "count", "is_active", "brand_id", "category_id"
    ];
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
        return $this->images->map(fn($image) => asset($image->url));
    }
    public function getCreatedAtAttribute($value)
    {
        $createdAt = Carbon::parse($value);        
        return $createdAt->format('Y:m:d H:i:s');
    }

    public function scopeActive(Builder $query)
    {
        $query->where("is_active", "=", 1);
    }

    public function isActive()
    {
        if($this->is_active == 1){
            return true;
        }else{
            return false;
        }
    }
}
