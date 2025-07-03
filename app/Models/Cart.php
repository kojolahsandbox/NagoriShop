<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['user_id', 'product_id', 'variant', 'quantity'];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
