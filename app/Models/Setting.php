<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Setting extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['option_key', 'option_value'];

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

}
