<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\cow;
use App\Models\milks;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class Milksimport implements ToModel, WithHeadingRow, WithCustomCsvSettings, WithMapping
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
        $date2 = null;

        // Check if 'farmentrydate' is provided
        if (!empty($row['date'])) {
            $date = Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d');
        }
        if (!empty($row['dryingdate'])) {
            $date2 = Carbon::createFromFormat('d/m/Y', $row['dryingdate'])->format('Y-m-d');
        }

        $cow = cow::where('cownumber', $row['cownumber'])->first();

        if (!$cow) {
            return null;
        }
        return new milks([
            "cownumber" => $cow->id,
            "date" => $date,
            "morningamount" => $row['morningamount'],
            "noonamount" => $row['noonamount'],
            "afternoonamount" => $row['afternoonamount'],
            "dryingdate" => $date2,
        ]);
    }

    public function map($row): array
    {
        // Check if the 'dateofbirth' is a double (Excel serialized date)
        if (is_numeric($row['date'])) {
            $row['date'] = Date::excelToDateTimeObject($row['date'])
                ->format('d/m/Y');
        }
        if (is_numeric($row['dryingdate'])) {
            $row['dryingdate'] = Date::excelToDateTimeObject($row['dryingdate'])
                ->format('d/m/Y');
        }

        return $row;
    }
}