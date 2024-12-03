<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use Illuminate\Http\Request;
use App\Exports\BreedsExport;
use App\Exports\accountsExport;
use App\Imports\accountsimport;
use Maatwebsite\Excel\Facades\Excel;

class accountsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-account|edit-account|delete-account', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-account', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-account', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-account', ['only' => ['destroy']]);
    }

    public function index()
    {
        $accounts = accounts::all();
        return view('accounts.index', compact('accounts'));
    }
    public function update($id, Request $request)
    {
        $request->validate(
            [
                // 'name' => 'required|unique:accounts,name,' . $id,
                'creditorordebtor' => 'required',
                'accountbalance' => 'required',

            ],
            [
                'creditorordebtor.required' => ' دائن او مدين
            مطلوب',
                'accountbalance.required' => ' رصيد الحساب
            مطلوب',
                // 'name.required' => 'الاسم   مطلوب',
                // 'name.unique' => 'الاسم  موجود من قبل',


            ]
        );
        $accounts = accounts::find($id);
        // $accounts->name = request('name');
        $accounts->creditorordebtor = request('creditorordebtor');
        $accounts->accountbalance = request('accountbalance');
        $accounts->save();

        return redirect()->route('accounts.index')->with('success', 'تم تعديل الحساب بنجاح');
    }




    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:accounts,name',
                'creditorordebtor' => 'required',
                'accountbalance' => 'required',

            ],
            [
                'creditorordebtor.required' => ' دائن او مدين
            مطلوب',
                'accountbalance.required' => ' رصيد الحساب
            مطلوب',
                'name.required' => 'الاسم   مطلوب',
                'name.unique' => 'الاسم  موجود من قبل',


            ]
        );

        $accounts = new  accounts();
        $accounts->name = request('name');
        $accounts->creditorordebtor = request('creditorordebtor');
        $accounts->accountbalance = request('accountbalance');
        $accounts->save();

        return redirect()->route('accounts.index')->with('success', 'تم اضافة الحساب بنجاح');
    }
    public function destroy()
    {
        accounts::findOrFail(request()->id)->delete();
        return redirect()->route('accounts.index')->with('success', 'تم حذف  الحساب بنجاح');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Perform the search query using your breeds model
        $accounts = accounts::where('name', 'like', '%' . $search . '%')
            ->get();

        return view('accounts.index', ['accounts' => $accounts]);
    }
    public function export()
    {
        $filename = 'customers' . now()->format('YmdHis') . '.xlsx';

        return Excel::download(new accountsExport(), $filename);
    }

    public function import(Request $request)
    {
        // $filename = 'cows' . now()->format('YmdHis') . '.xlsx';

        $request->validate(
            [
                'file' => 'required|mimes:xlsx',
            ],
            [
                'file.required' => 'ملف  الحسابات مطلوب',
                'file.mimes' => ' يجب ان يكون نوع الملف xlsx',
            ]
        );

        try {
            Excel::import(new accountsimport(), $request->file);
            return redirect()->back()->with('success', 'تم استيراد البيانات بنجاح.');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء استيراد البيانات. يرجى التحقق من تنسيق الملف والمحاولة مرة أخرى.');
        }
    }
}
