<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class milks extends Model
{
    use HasFactory;
    protected $fillable = [
        'cownumber',
        'date',
        'morningamount',
        'noonamount',
        'afternoonamount',
        'dryingdate',
    ];
    public function cowse()
    {
        return $this->belongsTo(cow::class, 'cownumber');
    }
}
