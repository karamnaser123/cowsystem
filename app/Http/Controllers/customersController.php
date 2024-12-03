<?php

namespace App\Http\Controllers;

use App\Models\customers;
use Illuminate\Http\Request;
use App\Exports\BreedsExport;
use App\Exports\customerExport;
use App\Imports\customerimport;
use Maatwebsite\Excel\Facades\Excel;

class customersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-customer|edit-customer|delete-customer', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-customer', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-customer', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-customer', ['only' => ['destroy']]);
    }
    public function index()
    {
        $customers = customers::all();
        return view('customers.index', compact('customers'));
    }
    public function update($id, Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:customers,name,' . $id,
                'phone' => 'required',

            ],
            [
                'name.required' => ' الزبون
            مطلوب',
                'name.unique' => 'هذا الاسم موجود بالفعل',
                'phone.required' => 'رقم الهاتف مطلوب',



            ]
        );
        $customers = customers::find($id);
        $customers->name = request('name');
        $customers->phone = request('phone');
        $customers->save();

        return redirect()->route('customers.index')->with('success', 'تم تعديل الزبون بنجاح');
    }




    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:customers,name',
                'phone' => 'required',

            ],
            [
                'name.required' => 'الزبون
                مطلوبة',
                'name.unique' => 'هذا الاسم موجود بالفعل',
                'phone.required' => 'رقم الهاتف مطلوب',


            ]
        );
        $customers = new  customers();
        $customers->name = request('name');
        $customers->phone = request('phone');
        $customers->save();

        return redirect()->route('customers.index')->with('success', 'تم اضافة الزبون بنجاح');
    }
    public function destroy()
    {
        customers::findOrFail(request()->id)->delete();
        return redirect()->route('customers.index')->with('success', 'تم حذف  الزبون بنجاح');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Perform the search query using your breeds model
        $suppliers = customers::where('name', 'like', '%' . $search . '%')
            ->get();

        return view('customers.index', ['suppliers' => $suppliers]);
    }
    public function export()
    {
        $filename = 'customers' . now()->format('YmdHis') . '.xlsx';

        return Excel::download(new customerExport(), $filename);
    }

    public function import(Request $request)
    {
        // $filename = 'cows' . now()->format('YmdHis') . '.xlsx';

        $request->validate(
            [
                'file' => 'required|mimes:xlsx',
            ],
            [
                'file.required' => 'ملف  العملاء مطلوب',
                'file.mimes' => ' يجب ان يكون نوع الملف xlsx',
            ]
        );

        try {
            Excel::import(new customerimport(), $request->file);
            return redirect()->back()->with('success', 'تم استيراد البيانات بنجاح.');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء استيراد البيانات. يرجى التحقق من تنسيق الملف والمحاولة مرة أخرى.');
        }
    }
}
