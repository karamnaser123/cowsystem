<?php

namespace App\Exports;

use App\Models\cowexpenses;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class CowexpensesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return cowexpenses::all()->makeHidden(['created_at', 'updated_at', 'image', 'id']);
    }

    public function headings(): array
    {

        return [
            'name',
            "quantity",
            // Add other fields as needed
        ];
    }
}
