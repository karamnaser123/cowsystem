<?php

namespace App\Imports;

use App\Models\accounts;
use App\Models\purchases;
use App\Models\suppliers;
use App\Models\paymentmethods;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class purchasesimport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $supplier = suppliers::find($row['supplierid']);

        if (!$supplier) {
            // Handle the case where the supplier is not found
            return null;
        }

        $purchases = new purchases([
            "supplierid" => $row['supplierid'],
            "productname" => $row['productname'],
            "purchasingprice" => $row['purchasingprice'],
            "productquantity" => $row['productquantity'],
            "totalprice" => $row['purchasingprice'] * $row['productquantity'],
            "payment_id" => $row['payment_id'],
        ]);

        $payment = paymentmethods::find($row['payment_id']);

        if ($payment && $payment->id == 3) {
            $supplierAccount = accounts::where('name', $supplier->name)->first();

            if ($supplierAccount) {
                // Update the account balance for the supplier
                $supplierAccount->update([
                    'accountbalance' => $supplierAccount->accountbalance + ($row['purchasingprice'] * $row['productquantity']),
                ]);
            } else {
                // Create a new account for the supplier
                $account = new accounts();
                $account->name = $supplier->name;
                $account->creditorordebtor = 0;
                $account->accountbalance = $row['purchasingprice'] * $row['productquantity'];
                $account->save();
            }
        }

        return $purchases;
    }
}
