<?php

namespace App\Exports;

use App\Models\expenses;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class expensesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return expenses::all()->makeHidden(['created_at', 'updated_at', 'id']);
    }

    public function headings(): array
    {
        return [
            'typeofexpense',
            'amount',
        ];
    }
}
