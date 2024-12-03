<?php

namespace App\Imports;

use App\Models\expenses;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class expensesimport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new expenses([
            "typeofexpense" => $row['typeofexpense'],
            "amount" => $row['amount'],
        ]);
    }
}
