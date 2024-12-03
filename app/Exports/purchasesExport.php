<?php

namespace App\Exports;

use App\Models\purchases;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class purchasesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return purchases::all()->makeHidden(['created_at', 'updated_at', 'id']);
    }

    public function headings(): array
    {
        return [
            'supplierid',
            'productname',
            'purchasingprice',
            'productquantity',
            'totalprice',
            'payment_id',
        ];
    }
}