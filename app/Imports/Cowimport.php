<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\cow;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class Cowimport implements ToModel, WithHeadingRow, WithCustomCsvSettings, WithMapping
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'UTF-8',
            'delimiter' => ',',
        ];
    }
    public function model(array $row)
    {
        $date = null;
        $date2 = null;
        $date3 = null;

        // Check if 'farmentrydate' is provided
        if (!empty($row['farmentrydate'])) {
            $date = Carbon::createFromFormat('d/m/Y', $row['farmentrydate'])->format('Y-m-d');
        }

        // Check if 'birthdate' is provided
        if (!empty($row['birthdate'])) {
            $date2 = Carbon::createFromFormat('d/m/Y', $row['birthdate'])->format('Y-m-d');
        }

        // Check if 'weaningdate' is provided
        if (!empty($row['weaningdate'])) {
            $date3 = Carbon::createFromFormat('d/m/Y', $row['weaningdate'])->format('Y-m-d');
        }
        $cow =  new cow([
            "cownumber" => $row['cownumber'],
            "mothernumber" => $row['mothernumber'],
            "farmentrydate" => $date,
            "weight" => $row['weight'],
            "purchasingprice" => $row['purchasingprice'],
            "expectedsaleprice" => $row['expectedsaleprice'],
            "dailyexpense" => $row['dailyexpense'],
            "status" => 1,
            "weaningdate" => $date3,
            "birthdate" => $date2
        ]);
        return $cow;
    }

    public function map($row): array
    {
        // Check if the 'dateofbirth' is a double (Excel serialized date)
        if (is_numeric($row['birthdate'])) {
            $row['birthdate'] = Date::excelToDateTimeObject($row['birthdate'])
                ->format('d/m/Y');
        }
        if (is_numeric($row['farmentrydate'])) {
            $row['farmentrydate'] = Date::excelToDateTimeObject($row['farmentrydate'])
                ->format('d/m/Y');
        }
        if (is_numeric($row['weaningdate'])) {
            $row['weaningdate'] = Date::excelToDateTimeObject($row['weaningdate'])
                ->format('d/m/Y');
        }
        return $row;
    }
}