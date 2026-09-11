<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penjualan extends Model
{

    use HasFactory;
    protected $table = 'penjualan';
    protected $fillable = [
        'user_id',
        'total_pembayaran',
        'metode_pembayaran',
        'uang_dibayar',
        'status'
    ];

    public function getKembalianAttribute()
    {
        if ($this->metode_pembayaran !== 'CASH' || is_null($this->uang_dibayar)) {
            return null;
        }

        return max(0, $this->uang_dibayar - $this->total_pembayaran);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function itemPenjualan()
    {
        return $this->hasMany(ItemPenjualan::class, 'penjualan_id');
    }

    public function details()
    {
        return $this->hasMany(ItemPenjualan::class, 'penjualan_id');
    }
}