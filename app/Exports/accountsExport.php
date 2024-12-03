<?php

namespace App\Exports;

use App\Models\accounts;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class accountsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return accounts::all()->makeHidden(['created_at', 'updated_at', 'id',]);
    }
    public function headings(): array
    {
        return [
            'name',
            'creditorordebtor',
            'accountbalance',
        ];
    }
}
