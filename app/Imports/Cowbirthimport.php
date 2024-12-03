<?php
// app/Imports/CowbirthImport.php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\cow;
use App\Models\Cowbirth;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class CowbirthImport implements ToModel, WithHeadingRow, WithCustomCsvSettings, WithMapping
{
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


        // Check if 'farmentrydate' is provided
        if (!empty($row['dateofbirth'])) {
            $date = Carbon::createFromFormat('d/m/Y', $row['dateofbirth'])->format('Y-m-d');
        }

        $cow = cow::where('cownumber', $row['cownumber'])->first();
        $cow2 = cow::where('mothernumber', $row['mothernumber'])->first();

        if (!$cow) {
            return null;
        }
        if (!$cow2) {
            return null;
        }
        return new Cowbirth([
            "cownumber" => $cow->id,
            "mothernumber" => $cow2->id,
            "dateofbirth" => $date,
            "gender" => $row['gender'],
            "note" => $row['note'],
        ]);
    }
    public function map($row): array
    {
        // Check if the 'dateofbirth' is a double (Excel serialized date)
        if (is_numeric($row['dateofbirth'])) {
            $row['dateofbirth'] = Date::excelToDateTimeObject($row['dateofbirth'])
                ->format('d/m/Y');
        }

        return $row;
    }
}