<?php

namespace App\Exports;

use App\Models\milks;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class MilksExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return milks::all()->makeHidden(['created_at', 'updated_at', 'id']);
    }
    public function headings(): array
    {
        // Define the column headers
        return [
            'cownumber',
            'date',
            'morningamount',
            'noonamount',
            'afternoonamount',
            'dryingdate',

        ];
    }
}
