<?php

namespace App\Http\Controllers;

use App\Models\milks;
use App\Exports\MilksExport;
use App\Imports\Milksimport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class milksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-milk|edit-milk|delete-milk', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-milk', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-milk', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-milk', ['only' => ['destroy']]);
    }
    public function index()
    {
        $milks = milks::all();
        return view('milks.index', compact('milks'));
    }
    public function update($id, Request $request)
    {
        $request->validate(
            [
                'cownumber' => 'required',
                // 'date' => 'required|date',
                // 'morningamount' => 'required|numeric',
                // 'noonamount' => 'required|numeric',
                // 'afternoonamount' => 'required|numeric',
            ],
            [
                'cownumber.unique' => 'رقم البقرة موجود من قبل',
                'cownumber.required' => 'رقم البقرة
                مطلوب',
                'date.required' => 'تاريخ العمل مطلوب',
                'date.date' => 'تاريخ العمل غير صحيح',
                'morningamount.required' => 'كمية الحليب في الصباح مطلوب',
                'morningamount.numeric' => 'كمية الحليب في الصباح يجب ان تكون رقم ',
                'noonamount.required' => 'كمية الحليب في الظهر مطلوبة',
                'noonamount.numeric' => 'كمية الحليب في الظهيرة يجب ان تكون رقم ',
                'afternoonamount.required' => 'كمية الحليب ما بعد الظهر مطلوبة',
                'afternoonamount.numeric' => 'كمية الحليب ما بعد الظهيرة يجب ان تكون رقم ',

            ]
        );
        $breeds = milks::find($id);
        $breeds->cownumber = request('cownumber');
        $breeds->date = request('date');
        $breeds->morningamount = request('morningamount');
        $breeds->noonamount = request('noonamount');
        $breeds->afternoonamount = request('afternoonamount');
        $breeds->dryingdate = request('dryingdate');
        $breeds->save();

        return redirect()->route('milks.index')->with('success', 'تم تعديل كمية الحليب بنجاح');
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'cownumber' => 'required',
                // 'date' => 'required|date',
                // 'morningamount' => 'required|numeric',
                // 'noonamount' => 'required|numeric',
                // 'afternoonamount' => 'required|numeric',
            ],
            [
                'cownumber.unique' => 'رقم البقرة موجود من قبل',
                'cownumber.required' => 'رقم البقرة
                مطلوب',
                'date.required' => 'تاريخ العمل مطلوب',
                'date.date' => 'تاريخ العمل غير صحيح',
                'morningamount.required' => 'كمية الحليب في الصباح مطلوب',
                'morningamount.numeric' => 'كمية الحليب في الصباح يجب ان تكون رقم ',
                'noonamount.required' => 'كمية الحليب في الظهر مطلوبة',
                'noonamount.numeric' => 'كمية الحليب في الظهيرة يجب ان تكون رقم ',
                'afternoonamount.required' => 'كمية الحليب ما بعد الظهر مطلوبة',
                'afternoonamount.numeric' => 'كمية الحليب ما بعد الظهيرة يجب ان تكون رقم ',

            ]
        );
        $breeds = new  milks();
        $breeds->cownumber = request('cownumber');
        $breeds->date = request('date');
        $breeds->morningamount = request('morningamount');
        $breeds->noonamount = request('noonamount');
        $breeds->afternoonamount = request('afternoonamount');
        $breeds->dryingdate = request('dryingdate');
        $breeds->save();

        return redirect()->route('milks.index')->with('success', 'تم اضافة كمية الحليب بنجاح');
    }
    public function destroy()
    {
        milks::findOrFail(request()->id)->delete();
        return redirect()->route('milks.index')->with('success', 'تم حذف كمية الحليب بنجاح');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Perform the search query using your breeds model
        $milks = milks::whereHas('cowse', function ($query) use ($search) {
            $query->where('cownumber', 'like', '%' . $search . '%');
        })
            ->orWhere('date', 'like', '%' . $search . '%')
            ->orWhere('morningamount', 'like', '%' . $search . '%')
            ->orWhere('noonamount', 'like', '%' . $search . '%')
            ->orWhere('afternoonamount', 'like', '%' . $search . '%')
            ->get();

        return view('milks.index', ['milks' => $milks]);
    }

    public function export()
    {
        $filename = 'milks' . now()->format('YmdHis') . '.xlsx';

        return Excel::download(new MilksExport(), $filename);
    }

    public function import(Request $request)
    {
        // $filename = 'cows' . now()->format('YmdHis') . '.xlsx';

        $request->validate(
            [
                'file' => 'required|mimes:xlsx',
            ],
            [
                'file.required' => 'ملف حليب الابقار مطلوب',
                'file.mimes' => ' يجب ان يكون نوع الملف xlsx',
            ]
        );

        try {
            Excel::import(new Milksimport(), $request->file);
            return redirect()->back()->with('success', 'تم استيراد البيانات بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء استيراد البيانات. يرجى التحقق من تنسيق الملف والمحاولة مرة أخرى.');
        }
    }
}