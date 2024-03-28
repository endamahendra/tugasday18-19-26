<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_po',
        'tanggal',
        'supplier_id',
        'product_id',
        'qty',
        'total',
        'keterangan',
    ];

    // Relasi dengan Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Relasi dengan Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
