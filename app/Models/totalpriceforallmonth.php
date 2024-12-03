<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class totalpriceforallmonth extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'year',
        'month',
        'totalprice',
    ];
 
}
