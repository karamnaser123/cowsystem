<?php

namespace App\Imports;

use App\Models\sales;
use App\Models\accounts;
use App\Models\products;
use App\Models\customers;
use App\Models\paymentmethods;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class salesimport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $customer = customers::find($row['customerid']);

        if (!$customer) {
            // Handle the case where the supplier is not found
            return null;
        }
        $sales =  new sales([
            "customerid" => $row['customerid'],
            "products_id" => $row['products_id'],
            "price" => $row['price'],
            "productquantity" => $row['productquantity'],
            "totalprice" => $row['totalprice'],
            "discount" => $row['discount'],
            "datesale" => $row['datesale'],
            "payment_id" => $row['payment_id'],
            "bankname" => $row['bankname'],
            "checknumber" => $row['checknumber'],
            "exchangedate" => $row['exchangedate'],
        ]);

        $product = products::find($row['products_id']);
        if ($product) {
            $product->update([
                'quantity' => $product->quantity - $row['productquantity'],
            ]);
        }



        $payment = paymentmethods::find($row['payment_id']);

        if ($payment && $payment->id == 3) {
            $Account = accounts::where('name', $customer->name)->first();

            if ($Account) {
                // Update the account balance for the supplier
                $Account->update([
                    'accountbalance' => $Account->accountbalance - ($product->productprice * $row['productquantity']),
                ]);
            } else {
                // Create a new account for the supplier
                $account = new accounts();
                $account->name = $customer->name;
                $account->creditorordebtor = 1;
                $account->accountbalance -= $product->productprice * $row['productquantity'];
                $account->save();
            }
        }

        return $sales;
    }
}
