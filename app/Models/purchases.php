<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchases extends Model
{
    use HasFactory;
    protected $fillable = [
        'supplierid',
        'productname',
        'purchasingprice',
        'productquantity',
        'totalprice',
        'payment_id',
        'bankname',
        'checknumber',
        'exchangedate',
    ];

    public function supplier()
    {
        return $this->belongsTo(suppliers::class, 'supplierid');
    }
    public function payment()
    {
        return $this->belongsTo(paymentmethods::class, 'payment_id');
    }
}
