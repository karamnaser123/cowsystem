<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\products;
use App\Models\purchases;
use Illuminate\Http\Request;
use App\Exports\BreedsExport;
use App\Exports\purchasesExport;
use App\Imports\purchasesimport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class purchasesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-purchases|edit-purchases|delete-purchases', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-purchases', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-purchases', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-purchases', ['only' => ['destroy']]);
    }

    public function index()
    {
        $purchases = purchases::all();
        return view('purchases.index', compact('purchases'));
    }
    public function update($id, Request $request)
    {
        $request->validate(
            [
                'supplierid' => 'required',
                'productname' => 'required',
                'purchasingprice' => 'required',
                'productquantity' => 'required|numeric|min:1',
                'payment_id' => 'required',
            ],
            [
                'supplierid.required' => 'اسم المورد 
                مطلوب',
                'productname.required' => ' اسم المنتج مطلوب',
                'purchasingprice.required' => 'سعر الشراء  مطلوب',
                'productquantity.required' => 'كمية المشتراه  مطلوبه',
                'totalprice.required' => '  السعر الاجمالي مطلوب',
                'payment_id.required' => '  طريقة الدفع  مطلوبه',

            ]
        );



        $product = products::where('productname', $request->input('productname'))->first();
        if (!$product) {
            return redirect()->back()->with('error', 'المنتج غير موجود');
        }

        $purchases = purchases::find($id);
        $quantityChange = request('productquantity') - $purchases->productquantity;

        // Update product quantity
        $product->quantity += $quantityChange;
        $product->save();

        $account = accounts::where('name', $purchases->supplier->name)->first();

        if ($purchases->payment->name == 'مؤجل') {
            if ($account) {
                // Update existing account
                $balance = $purchases->totalprice - (request('purchasingprice') * request('productquantity'));
                $account->accountbalance -= $balance;
                $account->save();
            }
        }
        $purchases->supplierid = request('supplierid');
        $purchases->productname = request('productname');
        $purchases->purchasingprice = request('purchasingprice');
        $purchases->productquantity = request('productquantity');
        $purchases->totalprice =  request('purchasingprice') *  request('productquantity');
        $purchases->payment_id = request('payment_id');
        $purchases->bankname = request('bankname');
        $purchases->checknumber = request('checknumber');
        $purchases->exchangedate = request('exchangedate');
        $purchases->save();








        return redirect()->route('purchases.index')->with('success', 'تم تعديل المشتريات بنجاح');
    }



    public function store(Request $request)
    {
        $request->validate(
            [
                'supplierid' => 'required',
                'productname' => 'required',
                'purchasingprice' => 'required',
                'productquantity' => 'required|numeric|min:1',
                'payment_id' => 'required',
            ],
            [
                'supplierid.required' => 'اسم المورد 
                مطلوب',
                'productname.required' => ' اسم المنتج مطلوب',
                'purchasingprice.required' => 'سعر الشراء  مطلوب',
                'productquantity.required' => 'كمية المشتراه  مطلوبه',
                'totalprice.required' => '  السعر الاجمالي مطلوب',
                'payment_id.required' => '  طريقة الدفع  مطلوبه',

            ]
        );


        $product = products::where('productname', $request->input('productname'))->first();

        if ($product) {
            $product->quantity += $request->input('productquantity');
            $product->save();
        } else {
            // If the product does not exist, create a new one
            $newProduct = new products;
            $newProduct->productname = $request->input('productname');
            $newProduct->productprice = $request->input('purchasingprice') + 5;
            $newProduct->quantity = $request->input('productquantity');
            $newProduct->save();
        }

        $purchases = new  purchases();
        $purchases->supplierid = request('supplierid');
        $purchases->productname = request('productname');
        $purchases->purchasingprice = request('purchasingprice');
        $purchases->productquantity = request('productquantity');
        $purchases->totalprice =  request('purchasingprice') *  request('productquantity');
        $purchases->payment_id = request('payment_id');
        $purchases->bankname = request('bankname');
        $purchases->checknumber = request('checknumber');
        $purchases->exchangedate = request('exchangedate');
        $purchases->save();

        $account = accounts::where('name', $purchases->supplier->name)->first();

        if ($purchases->payment->name == 'مؤجل') {
            if ($account) {
                // Update existing account
                $account->accountbalance += $purchases->totalprice;
                $account->save();
            } else {
                // Create a new account
                $account = new accounts;
                $account->name = $purchases->supplier->name;
                $account->creditorordebtor = 0;
                $account->accountbalance = $purchases->totalprice;
                $account->save();
            }
        }


        return redirect()->route('purchases.index')->with('success', 'تم اضافة المشتريات بنجاح');
    }
    public function destroy()
    {
        purchases::findOrFail(request()->id)->delete();
        return redirect()->route('purchases.index')->with('success', 'تم حذف المشتريات بنجاح');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Perform the search query using your breeds model
        $purchases = purchases::whereHas('supplier', function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
            ->orwhereHas('payment', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orWhere('productname', 'like', '%' . $search . '%')
            ->orWhere('purchasingprice', 'like', '%' . $search . '%')
            ->orWhere('created_at', 'like', '%' . $search . '%')

            ->get();

        return view('purchases.index', ['purchases' => $purchases]);
    }
    public function export()
    {
        $filename = 'purchases' . now()->format('YmdHis') . '.xlsx';

        return Excel::download(new purchasesExport(), $filename);
    }


    public function import(Request $request)
    {
        // $filename = 'cows' . now()->format('YmdHis') . '.xlsx';

        $request->validate(
            [
                'file' => 'required|mimes:xlsx',
            ],
            [
                'file.required' => 'ملف  المشتريات مطلوب',
                'file.mimes' => ' يجب ان يكون نوع الملف xlsx',
            ]
        );

        try {
            Excel::import(new purchasesimport(), $request->file);
            return redirect()->back()->with('success', 'تم استيراد البيانات بنجاح.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء استيراد البيانات. يرجى التحقق من تنسيق الملف والمحاولة مرة أخرى.');
        }
    }
}