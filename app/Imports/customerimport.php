<?php

namespace App\Imports;

use App\Models\customers;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class customerimport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        return new customers([
            "name" => $row['name'],
            "phone" => $row['phone'],
        ]);
    }
}
