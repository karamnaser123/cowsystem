<?php

namespace App\Imports;

use App\Models\accounts;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class accountsimport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new accounts([
            "name" => $row['name'],
            "creditorordebtor" => $row['creditorordebtor'],
            "accountbalance" => $row['accountbalance'],
        ]);
    }
}
