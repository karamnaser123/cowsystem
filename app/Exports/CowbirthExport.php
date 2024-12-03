<?php

namespace App\Exports;

use App\Models\cowbirth;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class CowbirthExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return cowbirth::all()->makeHidden(['created_at', 'updated_at', 'id']);
        // $result = $cowBirthData->map(function ($cowBirth) {
        //     $cownumber = $cowBirth->cowse->cownumber ?? 'N/A';

        //     $data = $cowBirth;
        //     $data['cownumber'] = $cownumber;

        //     return $data;
        // });

        // return $result;
    }

    public function headings(): array
    {
        // Define the column headers
        return [
            'cownumber',
            'mothernumber',
            'dateofbirth',
            'gender',
            'note',
        ];
    }
}
