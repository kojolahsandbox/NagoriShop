<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['user_id', 'recipient_name', 'phone', 'address_text', 'is_default'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
