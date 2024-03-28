<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_so',
        'tanggal',
        'customer_id',
        'product_id',
        'qty',
        'total',
        'keterangan',
    ];

    // Relasi dengan Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi dengan Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
