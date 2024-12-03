<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accounts extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'creditorordebtor',
        'accountbalance',
    ];


    public function supplier()
    {
        return $this->belongsTo(suppliers::class, 'suppliername');
    }
    public function customer()
    {
        return $this->belongsTo(customers::class, 'customername');
    }
}
