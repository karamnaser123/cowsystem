<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\cow;
use App\Models\breeds;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class Breedsimport implements ToModel, WithHeadingRow, WithCustomCsvSettings, WithMapping
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

        $cow = cow::where('cownumber', $row['cownumber'])->first();

        if (!$cow) {
            return null;
        }

        $date = null;
        $date2 = null;
        $date3 = null;

        // Check if 'farmentrydate' is provided
        if (!empty($row['breedingdate'])) {
            $date = Carbon::createFromFormat('d/m/Y', $row['breedingdate'])->format('Y-m-d');
        }

        // Check if 'birthdate' is provided
        if (!empty($row['examinationdate'])) {
            $date2 = Carbon::createFromFormat('d/m/Y', $row['examinationdate'])->format('Y-m-d');
        }

        // Check if 'weaningdate' is provided
        if (!empty($row['expectedbirthdate'])) {
            $date3 = Carbon::createFromFormat('d/m/Y', $row['expectedbirthdate'])->format('Y-m-d');
        }
        return new breeds([
            "cownumber" => $cow->id,
            "breedingdate" => $date,
            "breedingtype" => $row['breedingtype'],
            "breedingstatus" => $row['breedingstatus'],
            "examinationdate" => $date2,
            "result" => $row['result'],
            "note" => $row['note'],
            "expectedbirthdate" => $date3,
            "cost" => $row['cost'],
            "pollinationby" => $row['pollinationby'],
        ]);
    }

    public function map($row): array
    {
        // Check if the 'dateofbirth' is a double (Excel serialized date)
        if (is_numeric($row['breedingdate'])) {
            $row['breedingdate'] = Date::excelToDateTimeObject($row['breedingdate'])
                ->format('d/m/Y');
        }
        if (is_numeric($row['examinationdate'])) {
            $row['examinationdate'] = Date::excelToDateTimeObject($row['examinationdate'])
                ->format('d/m/Y');
        }
        if (is_numeric($row['expectedbirthdate'])) {
            $row['expectedbirthdate'] = Date::excelToDateTimeObject($row['expectedbirthdate'])
                ->format('d/m/Y');
        }

        return $row;
    }
}