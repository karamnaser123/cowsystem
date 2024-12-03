<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sales extends Model
{
    use HasFactory;
    protected $fillable = [
        'customerid',
        'products_id',
        'productquantity',
        'payment_id',
        'totalprice',
        'bankname',
        'checknumber',
        'exchangedate',
        'price',
        'datesale',
    ];
    public function customer()
    {
        return $this->belongsTo(customers::class, 'customerid');
    }
    public function products()
    {
        return $this->belongsTo(products::class, 'products_id');
    }
    public function payment()
    {
        return $this->belongsTo(paymentmethods::class, 'payment_id');
    }
}
