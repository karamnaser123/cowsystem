<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\cowexpenses;
use Illuminate\Http\Request;
use App\Exports\BreedsExport;
use App\Exports\CowexpensesExport;
use App\Imports\Cowexpensesimport;
use Maatwebsite\Excel\Facades\Excel;

class cowexpensesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-cowexpenses|edit-cowexpenses|delete-cowexpenses', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-cowexpenses', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-cowexpenses', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-cowexpenses', ['only' => ['destroy']]);
    }
    public function index()
    {
        $cowexpenses = cowexpenses::all();
        return view('cowexpenses.index', compact('cowexpenses'));
    }
    public function update($id, Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'quantity' => 'required',

            ],
            [
                'name.required' => ' الاسم
            مطلوب',
                'quantity.required' => 'الكمية  مطلوب',
            ]
        );



        $cowexpenses = cowexpenses::find($id);
        $product = products::where('productname', $cowexpenses->products->productname)->first();
        if (!$product) {
            return redirect()->back()->with('error', 'المنتج غير موجود');
        }
        $quantityChange = $cowexpenses->quantity - request('quantity');
        $product->quantity += $quantityChange;
        $product->save();
        $cowexpenses->name = request('name');
        $cowexpenses->quantity = request('quantity');
        $cowexpenses->save();

        return redirect()->route('cowexpenses.index')->with('success', 'تم تعديل مصاريف البقر بنجاح');
    }




    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'quantity' => 'required',

            ],
            [
                'name.required' => ' الاسم
            مطلوب',
                'quantity.required' => 'الكمية  مطلوب',
            ]
        );

        $cowexpenses = new  cowexpenses();
        $cowexpenses->name = request('name');
        $cowexpenses->quantity = request('quantity');
        $cowexpenses->save();

        $product = products::where('productname', $cowexpenses->products->productname)->first();

        if ($product) {
            $quantity = request('quantity');
            $product->quantity -= $quantity; // You may need to adjust this based on your specific logic
            $product->save();
        }


        return redirect()->route('cowexpenses.index')->with('success', 'تم اضافة مصاريف البقر بنجاح');
    }
    public function destroy()
    {
        cowexpenses::findOrFail(request()->id)->delete();
        return redirect()->route('cowexpenses.index')->with('success', 'تم حذف  مصاريف البقر بنجاح');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Perform the search query using your breeds model
        $cowexpenses = cowexpenses::where('name', 'like', '%' . $search . '%')
            ->get();

        return view('cowexpenses.index', ['cowexpenses' => $cowexpenses]);
    }
    public function export()
    {
        $filename = 'cowexpenses' . now()->format('YmdHis') . '.xlsx';

        return Excel::download(new CowexpensesExport(), $filename);
    }

    public function import(Request $request)
    {
        // $filename = 'cows' . now()->format('YmdHis') . '.xlsx';

        $request->validate(
            [
                'file' => 'required|mimes:xlsx',
            ],
            [
                'file.required' => 'ملف مصاريف الابقار مطلوب',
                'file.mimes' => ' يجب ان يكون نوع الملف xlsx',
            ]
        );

        try {
            Excel::import(new Cowexpensesimport(), $request->file);
            return redirect()->back()->with('success', 'تم استيراد البيانات بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء استيراد البيانات. يرجى التحقق من تنسيق الملف والمحاولة مرة أخرى.');
        }
    }
}
