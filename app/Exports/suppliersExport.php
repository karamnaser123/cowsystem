<?php

namespace App\Exports;

use App\Models\suppliers;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class suppliersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return suppliers::all()->makeHidden(['created_at', 'updated_at',  'id']);
    }

    public function headings(): array
    {

        return [
            'name',
            "phone",
            // Add other fields as needed
        ];
    }
}
