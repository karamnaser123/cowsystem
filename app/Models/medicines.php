<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medicines extends Model
{
    use HasFactory;
    protected $fillable = [
        'cownumber',
        'doctor',
        'identifydate',
        'startdate',
        'enddate',
        'nextfollowupdate',
        'typeofmedication',
        'numberofdoses',
    ];
    public function cowse()
    {
        return $this->belongsTo(cow::class, 'cownumber');
    }
}
