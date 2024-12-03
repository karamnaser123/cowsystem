<?php

namespace App\Imports;

use App\Models\products;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class productsimport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $existingProduct = products::where('productname', $row['productname'])->first();

        // If the product exists, update the quantity
        if ($existingProduct) {
            $existingProduct->update([
                'quantity' => $existingProduct->quantity + $row['quantity'],
            ]);

            // Return null to skip creating a new entry for this row
            return null;
        }

        // If the product does not exist, create a new one
        return new products([
            "productname" => $row['productname'],
            "productprice" => $row['productprice'],
            "quantity" => $row['quantity'],
        ]);
    }
}
