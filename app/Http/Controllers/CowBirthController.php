<?php

namespace App\Http\Controllers;

use App\Models\cowbirth;
use Illuminate\Http\Request;
use App\Exports\CowbirthExport;
use App\Imports\Cowbirthimport;
use Maatwebsite\Excel\Facades\Excel;

class CowBirthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-cowbirth|edit-cowbirth|delete-cowbirth', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-cowbirth', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-cowbirth', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-cowbirth', ['only' => ['destroy']]);
    }
    public function index()
    {
        $cowbirth = cowbirth::all();
        return view('cowbirth.index', compact('cowbirth'));
    }
    public function update($id, Request $request)
    {
        $request->validate(
            [
                // 'cownumber' => 'required',
                // 'mothernumber' => 'required',
                // 'dateofbirth' => 'required|date',
                // 'gender' => 'required',
            ],
            [
                // 'cownumber.unique' => 'رقم البقرة موجود من قبل',
                // 'cownumber.required' => 'رقم البقرة
                // مطلوب',
                // 'mothernumber.required' => 'رقم الام
                // مطلوب',
                // 'dateofbirth.required' => 'تاريخ الولادة مطلوب',
                // 'dateofbirth.date' => 'تاريخ الولادة غير صحيح',
                // 'gender.required' => 'جنس البقرة  مطلوب',
            ]
        );
        $cowbirth = cowbirth::find($id);
        $cowbirth->cownumber = request('cownumber');
        $cowbirth->mothernumber = request('mothernumber');
        $cowbirth->dateofbirth = request('dateofbirth');
        $cowbirth->gender = request('gender');
        $cowbirth->note = request('note');
        $cowbirth->save();

        return redirect()->route('cowbirth.index')->with('success', 'تم تعديل المولود بنجاح');
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                // 'cownumber' => 'required',
                // 'mothernumber' => 'required',
                // 'dateofbirth' => 'required|date',
                // 'gender' => 'required',
            ],
            [
                // 'cownumber.unique' => 'رقم البقرة موجود من قبل',
                // 'cownumber.required' => 'رقم البقرة
                // مطلوب',
                // 'mothernumber.required' => 'رقم الام
                // مطلوب',
                // 'dateofbirth.required' => 'تاريخ الولادة مطلوب',
                // 'dateofbirth.date' => 'تاريخ الولادة غير صحيح',
                // 'gender.required' => 'جنس البقرة  مطلوب',
            ]
        );
        $cowbirth = new  cowbirth();
        $cowbirth->cownumber = request('cownumber');
        $cowbirth->mothernumber = request('mothernumber');
        $cowbirth->dateofbirth = request('dateofbirth');
        $cowbirth->gender = request('gender');
        $cowbirth->note = request('note');
        $cowbirth->save();

        return redirect()->route('cowbirth.index')->with('success', 'تم اضافة المولد بنجاح');
    }
    public function destroy()
    {
        cowbirth::findOrFail(request()->id)->delete();
        return redirect()->route('cowbirth.index')->with('success', 'تم حذف المولود بنجاح');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Perform the search query using your breeds model

        $cowbirth = cowbirth::whereHas('cowse', function ($query) use ($search) {
            $query->where('cownumber', 'like', '%' . $search . '%');
        })
            ->orWhereHas('cowse2', function ($query) use ($search) {
                $query->where('cownumber', 'like', '%' . $search . '%');
            })
            ->orWhere('dateofbirth', 'like', '%' . $search . '%')
            ->orWhere('gender', 'like', '%' . $search . '%')
            ->orWhere('note', 'like', '%' . $search . '%')
            ->get();

        return view('cowbirth.index', ['cowbirth' => $cowbirth]);
    }

    public function export()
    {
        $filename = 'cowbirth' . now()->format('YmdHis') . '.xlsx';

        return Excel::download(new CowbirthExport(), $filename);
    }
    public function import(Request $request)
    {
        // $filename = 'cows' . now()->format('YmdHis') . '.xlsx';

        $request->validate(
            [
                'file' => 'required|mimes:xlsx',
            ],
            [
                'file.required' => 'ملف مواليد الابقار مطلوب',
                'file.mimes' => ' يجب ان يكون نوع الملف xlsx',
            ]
        );

        try {
            Excel::import(new Cowbirthimport(), $request->file);
            return redirect()->back()->with('success', 'تم استيراد البيانات بنجاح.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء استيراد البيانات. يرجى التحقق من تنسيق الملف والمحاولة مرة أخرى.');
        }
    }
}
