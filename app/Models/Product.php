<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Product extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['seller_id', 'name', 'description', 'image', 'price', 'category', 'stock'];

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

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

}
