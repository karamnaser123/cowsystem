<?php

namespace App\Exports;

use App\Models\sales;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class salesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return sales::all()->makeHidden(['created_at', 'updated_at', 'id']);
    }

    public function headings(): array
    {
        return [
            'customerid',
            'products_id',
            'price',
            'productquantity',
            'totalprice',
            'discount',
            'datesale',
            'payment_id',
            'bankname',
            'checknumber',
            'exchangedate',
        ];
    }
}
