<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrderItem extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'variant',
        'quantity',
        'unit_price'
    ];

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

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
