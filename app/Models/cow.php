<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cow extends Model
{
    use HasFactory;
    protected $fillable = [
        'cownumber',
        'mothernumber',
        'farmentrydate',
        'weight',
        'purchasingprice',
        'expectedsaleprice',
        'dailyexpense',
        'status',
        'image',
        'weaningdate',
        'birthdate',
        'qrcode',
    ];
    // Inside the cow model
    public function breeds()
    {
        return $this->hasMany(breeds::class, 'cownumber');
    }

    public function medicines()
    {
        return $this->hasMany(medicines::class, 'cownumber');
    }

    public function milks()
    {
        return $this->hasMany(milks::class, 'cownumber');
    }

    public function cowbirth()
    {
        return $this->hasMany(cowbirth::class, 'mothernumber');
    }
}
