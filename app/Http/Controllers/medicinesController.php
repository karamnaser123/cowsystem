<?php

namespace App\Http\Controllers;

use App\Models\cow;
use App\Models\medicines;
use Illuminate\Http\Request;
use App\Exports\MedicinesExport;
use App\Imports\Medicinesimport;
use Maatwebsite\Excel\Facades\Excel;

class medicinesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-medicine|edit-medicine|delete-medicine', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-medicine', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-medicine', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-medicine', ['only' => ['destroy']]);
    }
    public function index()
    {
        $medicines = medicines::all();
        return view('medicines.index', compact('medicines'));
    }
    public function update($id, Request $request)
    {
        $request->validate(
            [
                'cownumber' => 'required',
                // 'doctor' => 'required',
                // 'identifydate' => 'required|date',
                // 'startdate' => 'required|date',
                // 'enddate' => 'required|date',
                // 'nextfollowupdate' => 'required|date',
                // 'typeofmedication' => 'required',
                // 'numberofdoses' => 'required',
            ],
            [
                'cownumber.unique' => 'موعد الدواء للبقرة موجود من قبل',
                'cownumber.required' => 'رقم البقرة مطلوب',
                'doctor.required' => 'الطبيب  مطلوب',
                'identifydate.required' => ' تحديد  التاريخ',
                'startdate.required' => ' تاريخ البدء مطلوب',
                'enddate.required' => ' تاريخ الانتهاء مطلوب',
                'nextfollowupdate.required' => ' تاريخ المتابعة التالي مطلوب',
                'typeofmedication.required' => ' نوع الدواء مطلوب',
                'numberofdoses.required' => ' عدد الجرعات مطلوب',
            ]
        );
        $medicines = medicines::find($id);
        $medicines->cownumber = request('cownumber');
        $medicines->doctor = request('doctor');
        $medicines->identifydate = request('identifydate');
        $medicines->startdate = request('startdate');
        $medicines->enddate = request('enddate');
        $medicines->nextfollowupdate = request('nextfollowupdate');
        $medicines->typeofmedication = request('typeofmedication');
        $medicines->numberofdoses = request('numberofdoses');
        $medicines->save();

        return redirect()->route('medicines.index')->with('success', 'تم تعديل موعد الدواء بنجاح');
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'cownumber' => 'required',
                // 'doctor' => 'required',
                // 'identifydate' => 'required|date',
                // 'startdate' => 'required|date',
                // 'enddate' => 'required|date',
                // 'nextfollowupdate' => 'required|date',
                // 'typeofmedication' => 'required',
                // 'numberofdoses' => 'required',
            ],
            [
                'cownumber.unique' => 'موعد الدواء للبقرة موجود من قبل',
                'cownumber.required' => 'رقم البقرة مطلوب',
                'doctor.required' => 'الطبيب  مطلوب',
                'identifydate.required' => ' تحديد  التاريخ',
                'startdate.required' => ' تاريخ البدء مطلوب',
                'enddate.required' => ' تاريخ الانتهاء مطلوب',
                'nextfollowupdate.required' => ' تاريخ المتابعة التالي مطلوب',
                'typeofmedication.required' => ' نوع الدواء مطلوب',
                'numberofdoses.required' => ' عدد الجرعات مطلوب',
            ]
        );
        $medicines = new  medicines();
        $medicines->cownumber = request('cownumber');
        $medicines->doctor = request('doctor');
        $medicines->identifydate = request('identifydate');
        $medicines->startdate = request('startdate');
        $medicines->enddate = request('enddate');
        $medicines->nextfollowupdate = request('nextfollowupdate');
        $medicines->typeofmedication = request('typeofmedication');
        $medicines->numberofdoses = request('numberofdoses');
        $medicines->save();

        return redirect()->route('medicines.index')->with('success', 'تم اضافة موعد الدواء بنجاح');
    }
    public function destroy()
    {
        medicines::findOrFail(request()->id)->delete();
        return redirect()->route('medicines.index')->with('success', 'تم حذف موعد الدواء بنجاح');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Perform the search query using your Cow model
        $medicines = medicines::whereHas('cowse', function ($query) use ($search) {
            $query->where('cownumber', 'like', '%' . $search . '%');
        })
            ->orWhere('doctor', 'like', '%' . $search . '%')
            ->orWhere('identifydate', 'like', '%' . $search . '%')
            ->orWhere('startdate', 'like', '%' . $search . '%')
            ->orWhere('enddate', 'like', '%' . $search . '%')
            ->orWhere('nextfollowupdate', 'like', '%' . $search . '%')
            ->get();

        return view('medicines.index', ['medicines' => $medicines]);
    }

    public function export()
    {
        $filename = 'medicines' . now()->format('YmdHis') . '.xlsx';

        return Excel::download(new MedicinesExport(), $filename);
    }

    public function import(Request $request)
    {
        // $filename = 'cows' . now()->format('YmdHis') . '.xlsx';

        $request->validate(
            [
                'file' => 'required|mimes:xlsx',
            ],
            [
                'file.required' => 'ملف علاج الابقار مطلوب',
                'file.mimes' => ' يجب ان يكون نوع الملف xlsx',
            ]
        );

        try {
            Excel::import(new Medicinesimport(), $request->file);
            return redirect()->back()->with('success', 'تم استيراد البيانات بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء استيراد البيانات. يرجى التحقق من تنسيق الملف والمحاولة مرة أخرى.');
        }
    }
}