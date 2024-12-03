<?php

namespace App\Exports;

use App\Models\customers;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class customerExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return customers::all()->makeHidden(['created_at', 'updated_at',  'id']);
    }

    public function headings(): array
    {

        return [
            'name',
            "phone",
        ];
    }
}
