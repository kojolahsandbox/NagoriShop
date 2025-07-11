<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductVariant extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['product_id', 'variant_id', 'price', 'stock'];

    /**
     * Auto-generate UUID saat creating
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
