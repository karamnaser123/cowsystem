<?php

namespace App\Http\Controllers;

use App\Models\suppliers;
use Illuminate\Http\Request;
use App\Exports\BreedsExport;
use App\Exports\suppliersExport;
use App\Imports\suppliersimport;
use Maatwebsite\Excel\Facades\Excel;

class suppliersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-supplier|edit-supplier|delete-supplier', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-supplier', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-supplier', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-supplier', ['only' => ['destroy']]);
    }
    public function index()
    {
        $suppliers = suppliers::all();
        return view('suppliers.index', compact('suppliers'));
    }
    public function update($id, Request $request)
    {

        $request->validate(
            [
                'name' => 'required|unique:suppliers,name,' . $id,
                'phone' => 'required',


            ],
            [
                'name.required' => 'اسم المورد
            مطلوب',
                'name.unique' => 'هذا الاسم موجود بالفعل',
                'phone.required' => 'رقم الهاتف مطلوب',


            ]
        );
        $suppliers = suppliers::find($id);
        $suppliers->name = request('name');
        $suppliers->phone = request('phone');
        $suppliers->save();

        return redirect()->route('suppliers.index')->with('success', 'تم تعديل المورد بنجاح');
    }




    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:suppliers,name',
                'phone' => 'required',

            ],
            [
                'name.required' => 'المورد
                مطلوبة',
                'name.unique' => 'هذا الاسم موجود بالفعل',
                'phone.required' => 'رقم الهاتف مطلوب',

            ]
        );
        $suppliers = new  suppliers();
        $suppliers->name = request('name');
        $suppliers->phone = request('phone');
        $suppliers->save();

        return redirect()->route('suppliers.index')->with('success', 'تم اضافة المورد بنجاح');
    }
    public function destroy()
    {
        suppliers::findOrFail(request()->id)->delete();
        return redirect()->route('suppliers.index')->with('success', 'تم حذف  المورد بنجاح');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Perform the search query using your breeds model
        $suppliers = suppliers::where('name', 'like', '%' . $search . '%')
            ->get();

        return view('suppliers.index', ['suppliers' => $suppliers]);
    }
    public function export()
    {
        $filename = 'suppliers' . now()->format('YmdHis') . '.xlsx';

        return Excel::download(new suppliersExport(), $filename);
    }

    public function import(Request $request)
    {
        // $filename = 'cows' . now()->format('YmdHis') . '.xlsx';

        $request->validate(
            [
                'file' => 'required|mimes:xlsx',
            ],
            [
                'file.required' => 'ملف  الموردين مطلوب',
                'file.mimes' => ' يجب ان يكون نوع الملف xlsx',
            ]
        );

        try {
            Excel::import(new suppliersimport(), $request->file);
            return redirect()->back()->with('success', 'تم استيراد البيانات بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء استيراد البيانات. يرجى التحقق من تنسيق الملف والمحاولة مرة أخرى.');
        }
    }
}
