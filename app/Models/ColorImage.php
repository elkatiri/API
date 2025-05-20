<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ColorImage extends Model
{
    protected $fillable = ['product_color_id', 'image_path'];

    public function productColor(): BelongsTo
    {
        return $this->belongsTo(ProductColor::class);
    }
}
