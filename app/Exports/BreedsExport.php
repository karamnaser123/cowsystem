<?php

namespace App\Exports;

use App\Models\breeds;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class BreedsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return breeds::all()->makeHidden(['created_at', 'updated_at', 'id']);
    }
    public function headings(): array
    {
        return [
            'cownumber',
            'breedingdate',
            'breedingtype',
            'breedingstatus',
            'examinationdate',
            'result',
            'note',
            'expectedbirthdate',
            'cost',
            'pollinationby',
        ];
    }
}
