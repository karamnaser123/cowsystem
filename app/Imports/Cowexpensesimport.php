<?php

namespace App\Imports;

use App\Models\products;
use App\Models\cowexpenses;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Cowexpensesimport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $cowexpenses = new cowexpenses([
            "name" => $row['name'],
            "quantity" => $row['quantity'],
        ]);

        $product = products::find($row['name']);
        if ($product) {
            $product->update([
                'quantity' => $product->quantity - $row['quantity'],
            ]);
        }
        return $cowexpenses;
    }
}
