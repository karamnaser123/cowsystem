<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\cow;
use App\Models\medicines;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class Medicinesimport implements ToModel, WithHeadingRow, WithCustomCsvSettings, WithMapping
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
        $date4 = null;

        // Check if 'farmentrydate' is provided
        if (!empty($row['identifydate'])) {
            $date = Carbon::createFromFormat('d/m/Y', $row['identifydate'])->format('Y-m-d');
        }

        // Check if 'birthdate' is provided
        if (!empty($row['startdate'])) {
            $date2 = Carbon::createFromFormat('d/m/Y', $row['startdate'])->format('Y-m-d');
        }

        // Check if 'weaningdate' is provided
        if (!empty($row['enddate'])) {
            $date3 = Carbon::createFromFormat('d/m/Y', $row['enddate'])->format('Y-m-d');
        }
        if (!empty($row['nextfollowupdate'])) {
            $date4 = Carbon::createFromFormat('d/m/Y', $row['nextfollowupdate'])->format('Y-m-d');
        }
        $cow = cow::where('cownumber', $row['cownumber'])->first();

        if (!$cow) {
            return null;
        }
        return new medicines([
            "cownumber" => $cow->id,
            "doctor" => $row['doctor'],
            "identifydate" => $date,
            "startdate" => $date2,
            "enddate" => $date3,
            "nextfollowupdate" => $date4,
            "typeofmedication" => $row['typeofmedication'],
            "numberofdoses" => $row['numberofdoses'],

        ]);
    }

    public function map($row): array
    {
        // Check if the 'dateofbirth' is a double (Excel serialized date)
        if (is_numeric($row['identifydate'])) {
            $row['identifydate'] = Date::excelToDateTimeObject($row['identifydate'])
                ->format('d/m/Y');
        }
        if (is_numeric($row['startdate'])) {
            $row['startdate'] = Date::excelToDateTimeObject($row['startdate'])
                ->format('d/m/Y');
        }
        if (is_numeric($row['enddate'])) {
            $row['enddate'] = Date::excelToDateTimeObject($row['enddate'])
                ->format('d/m/Y');
        }
        if (is_numeric($row['nextfollowupdate'])) {
            $row['nextfollowupdate'] = Date::excelToDateTimeObject($row['nextfollowupdate'])
                ->format('d/m/Y');
        }

        return $row;
    }
}