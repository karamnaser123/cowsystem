<?php

namespace App\Exports;

use App\Models\products;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class productsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return products::all()->makeHidden(['created_at', 'updated_at', 'id', 'productimage']);
    }

    public function headings(): array
    {
        return [
            'productname',
            'productprice',
            'quantity',
        ];
    }
}
