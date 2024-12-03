<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class breeds extends Model
{
    use HasFactory;
    protected $fillable = [
        'cownumber',
        'breedingdate',
        'breedingtype',
        'breedingstatus',
        'expectedbirthdate',
        'cost',
        'pollinationby',
        'examinationdate',
        'result',
        'note',
    ];

    public function cowse()
    {
        return $this->belongsTo(cow::class, 'cownumber');
    }
}
