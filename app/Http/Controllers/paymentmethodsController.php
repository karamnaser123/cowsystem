<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\BreedsExport;
use App\Models\paymentmethods;
use Maatwebsite\Excel\Facades\Excel;

class paymentmethodsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-paymentmethod|edit-paymentmethod|delete-paymentmethod', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-paymentmethod', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-paymentmethod', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-paymentmethod', ['only' => ['destroy']]);
    }
    public function index()
    {
        $paymentmethods = paymentmethods::all();
        return view('paymentmethods.index', compact('paymentmethods'));
    }
    public function update($id, Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:paymentmethods,name',

            ],
            [
                'name.required' => 'طريقة الدفع 
                مطلوبة',
                'name.unique' => 'هذا الحقل موجود بالفعل',


            ]
        );
        $paymentmethods = paymentmethods::find($id);
        $paymentmethods->name = request('name');
        $paymentmethods->save();

        return redirect()->route('paymentmethods.index')->with('success', 'تم تعديل طريقة الدفع بنجاح');
    }




    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:paymentmethods,name',

            ],
            [
                'name.required' => 'طريقة الدفع 
                مطلوبة',
                'name.unique' => 'هذا الحقل موجود بالفعل',

            ]
        );
        $paymentmethods = new  paymentmethods();
        $paymentmethods->name = request('name');
        $paymentmethods->save();

        return redirect()->route('paymentmethods.index')->with('success', 'تم اضافة طريقة الدفع بنجاح');
    }
    public function destroy()
    {
        paymentmethods::findOrFail(request()->id)->delete();
        return redirect()->route('paymentmethods.index')->with('success', 'تم حذف طريقة الدفع بنجاح');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Perform the search query using your breeds model
        $paymentmethods = paymentmethods::where('name', 'like', '%' . $search . '%')
            ->get();

        return view('paymentmethods.index', ['paymentmethods' => $paymentmethods]);
    }
    public function export()
    {
        $filename = 'paymentmethods' . now()->format('YmdHis') . '.xlsx';

        return Excel::download(new BreedsExport(), $filename);
    }
}
