<?php

namespace App\Http\Controllers;

use App\Models\expenses;
use App\Models\products;
use Illuminate\Http\Request;
use App\Exports\BreedsExport;
use App\Exports\expensesExport;
use App\Imports\expensesimport;
use Maatwebsite\Excel\Facades\Excel;

class expensesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-expenses|edit-expenses|delete-expenses', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-expenses', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-expenses', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-expenses', ['only' => ['destroy']]);
    }
    public function index()
    {
        $expenses = expenses::all();
        return view('expenses.index', compact('expenses'));
    }
    public function update($id, Request $request)
    {
        $request->validate(
            [
                'typeofexpense' => 'required',
                'amount' => 'required',

            ],
            [
                'typeofexpense.required' => ' اسم المصروف
            مطلوب',
                'amount.required' => ' مقدار المصروف
            مطلوب',


            ]
        );



        $expenses = expenses::find($id);
        $expenses->typeofexpense = request('typeofexpense');
        $expenses->amount = request('amount');
        $expenses->save();

        return redirect()->route('expenses.index')->with('success', 'تم تعديل المصروف بنجاح');
    }




    public function store(Request $request)
    {
        $request->validate(
            [
                'typeofexpense' => 'required',
                'amount' => 'required',

            ],
            [
                'typeofexpense.required' => ' اسم المصروف
            مطلوب',
                'amount.required' => ' مقدار المصروف
            مطلوب',


            ]
        );


        $expenses = new  expenses();
        $expenses->typeofexpense = request('typeofexpense');
        $expenses->amount = request('amount');
        $expenses->save();



        return redirect()->route('expenses.index')->with('success', 'تم اضافة المصروف بنجاح');
    }
    public function destroy()
    {
        expenses::findOrFail(request()->id)->delete();
        return redirect()->route('expenses.index')->with('success', 'تم حذف  المصروف بنجاح');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Perform the search query using your breeds model
        $expenses = expenses::where('typeofexpense', 'like', '%' . $search . '%')
            ->orWhere('amount', 'like', '%' . $search . '%')
            ->orWhere('created_at', 'like', '%' . $search . '%')

            ->get();

        return view('expenses.index', ['expenses' => $expenses]);
    }
    public function export()
    {
        $filename = 'expenses' . now()->format('YmdHis') . '.xlsx';

        return Excel::download(new expensesExport(), $filename);
    }

    public function import(Request $request)
    {
        // $filename = 'cows' . now()->format('YmdHis') . '.xlsx';

        $request->validate(
            [
                'file' => 'required|mimes:xlsx',
            ],
            [
                'file.required' => 'ملف  المصروفات مطلوب',
                'file.mimes' => ' يجب ان يكون نوع الملف xlsx',
            ]
        );

        try {
            Excel::import(new expensesimport(), $request->file);
            return redirect()->back()->with('success', 'تم استيراد البيانات بنجاح.');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء استيراد البيانات. يرجى التحقق من تنسيق الملف والمحاولة مرة أخرى.');
        }
    }
}
