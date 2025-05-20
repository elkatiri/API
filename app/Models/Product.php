<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'quantity', 
        'discount', 'discount_expires_at', 'category_id'
    ];

    protected $casts = [
        'discount_expires_at' => 'datetime',
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function colors(): HasMany
    {
        return $this->hasMany(ProductColor::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}
