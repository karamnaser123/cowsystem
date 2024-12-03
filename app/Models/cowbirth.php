<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cowbirth extends Model
{
    use HasFactory;
    protected $fillable = [
        'cownumber',
        'mothernumber',
        'dateofbirth',
        'gender',
        'note',
    ];
    public function cowse()
    {
        return $this->belongsTo(cow::class, 'cownumber');
    }
    public function cowse2()
    {
        return $this->belongsTo(cow::class, 'mothernumber');
    }
}
