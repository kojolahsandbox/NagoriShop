<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    protected $fillable = ['name', 'description', 'image', 'price', 'category', 'stock'];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
