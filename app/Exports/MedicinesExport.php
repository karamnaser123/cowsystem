<?php

namespace App\Exports;

use App\Models\medicines;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class MedicinesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return medicines::all()->makeHidden(['created_at', 'updated_at', 'id']);
    }
    public function headings(): array
    {
        // Define the column headers
        return [
            'cownumber',
            'doctor',
            'identifydate',
            'startdate',
            'enddate',
            'nextfollowupdate',
            'typeofmedication',
            'numberofdoses',
        ];
    }
}
