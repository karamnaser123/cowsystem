<?php

namespace App\Imports;

use App\Models\suppliers;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class suppliersimport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new suppliers([
            "name" => $row['name'],
            "phone" => $row['phone'],
        ]);
    }
}
