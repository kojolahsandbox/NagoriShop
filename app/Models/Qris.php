<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Qris extends Model
{
    use HasFactory;

    // Tentukan primary key jika menggunakan UUID
    protected $primaryKey = 'id';

    // Pastikan `id` adalah UUID dan tidak auto increment
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'order_id',
        'qris_content',
        'qris_request_date',
        'qris_invoiceid',
        'qris_status',
        'qris_invoiceamount',
        'qris_invoicestatus'
    ];

    // Generate UUID secara otomatis saat membuat record baru
    protected static function booted()
    {
        static::creating(function ($qris) {
            if (!$qris->id) {
                $qris->id = (string) Str::uuid();
            }
        });
    }

    // Relasi ke model Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
