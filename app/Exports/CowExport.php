<?php

namespace App\Exports;

use App\Models\cow;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CowExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return cow::all()->makeHidden(['created_at', 'updated_at', 'image', 'id', 'qrcode', 'status']);
    }

    public function headings(): array
    {

        return [
            "cownumber",
            "mothernumber",
            "farmentrydate",
            "weight",
            "purchasingprice",
            "expectedsaleprice",
            "dailyexpense",
            "weaningdate",
            "birthdate",
            // Add other fields as needed
        ];
    }
}