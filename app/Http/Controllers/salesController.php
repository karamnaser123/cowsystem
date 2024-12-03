<?php

namespace App\Http\Controllers;

use App\Models\sales;
use App\Models\accounts;
use App\Models\products;
use App\Exports\salesExport;
use App\Imports\salesimport;
use Illuminate\Http\Request;
use App\Exports\BreedsExport;
use Maatwebsite\Excel\Facades\Excel;

class salesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-sales|edit-sales|delete-sales', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-sales', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-sales', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-sales', ['only' => ['destroy']]);
    }
    public function index()
    {
        $sales = sales::all();
        return view('sales.index', ['sales' => $sales]);
    }
    public function update($id, Request $request)
    {
        $request->validate(
            [
                'customerid' => 'required',
                'products_id' => 'required',
                'price' => 'nullable|numeric',
                'productquantity' => 'required|numeric|min:1',
                'payment_id' => 'required',
            ],
            [
                'customerid.required' => ' اسم الزبون
            مطلوب',

                'products_id.required' => ' اسم المنتج
            مطلوب',

                'productquantity.required' => ' كمية المنتج
            مطلوب',

                'payment_id.required' => ' طريقة الدفع 
            مطلوب',
                'price.required' => ' السعر مطلوب',
                'price.numeric' => 'يجب ان يكون رقم صحيح',



            ]
        );
        $product = products::findOrFail(request('products_id'));




        $sales = sales::find($id);

        $quantityChange = $sales->productquantity - request('productquantity');

        // Update product quantity
        $product->quantity += $quantityChange;
        $product->save();


        $account = accounts::where('name', $sales->customer->name)->first();

        if ($sales->payment->name == 'مؤجل') {
            if ($account) {
                // Update existing account
                $balance = $sales->totalprice - ($product->productprice * request('productquantity'));
                $account->accountbalance += $balance;
                $account->save();
            }
        }

        $sales->customerid = request('customerid');
        $sales->products_id = request('products_id');
        $sales->price = request('price');
        $sales->productquantity = request('productquantity');
        $sales->discount = request('discount');
        $sales->datesale = request('datesale');
        if (request('price')) {
            $sales->totalprice = request('price') * request('productquantity') - request('discount');
        } else {
            $sales->totalprice = $product->productprice * request('productquantity') - request('discount');
        }
        $sales->payment_id = request('payment_id');
        $sales->bankname = request('bankname');
        $sales->checknumber = request('checknumber');
        $sales->exchangedate = request('exchangedate');
        $sales->save();

        return redirect()->route('sales.index')->with('success', 'تم تعديل المبيعات بنجاح');
    }



    public function store(Request $request)
    {
        $request->validate([
            'customerid' => 'required',
            'products_id' => 'required',
            'price' => 'nullable|numeric',
            'productquantity' => 'required|numeric|min:1',
            'payment_id' => 'required',
        ], [
            'customerid.required' => 'اسم الزبون مطلوب',
            'products_id.required' => 'اسم المنتج مطلوب',
            'productquantity.required' => 'كمية المنتج مطلوبة',
            'payment_id.required' => 'طريقة الدفع مطلوبة',
            'price.numeric' => 'يجب ان يكون رقم صحيح',

        ]);

        // Fetch the product based on the provided 'products_id'
        $product = products::findOrFail(request('products_id'));


        if ($product) {
            // Get the existing quantity and the new quantity from the request
            $existingQuantity = $product->quantity;
            $newQuantity = $request->input('productquantity');

            // Check if the new quantity is greater than the existing quantity
            if ($newQuantity > $existingQuantity) {
                return redirect()->back()->with('error', 'الكمية المطلوبة أكبر من الكمية المتاحة');
            }

            // Handle the reduction in quantity
            $quantityDifference = $existingQuantity - $newQuantity;

            // Update the product's quantity
            $product->quantity -= $newQuantity;
            $product->save();
        }
        // Create a new sales instance
        $sales = new sales();

        // Set the values for the sales record
        $sales->customerid = request('customerid');
        $sales->products_id = request('products_id');
        $sales->price = request('price');
        $sales->productquantity = request('productquantity');
        $sales->discount = request('discount');
        $sales->datesale = request('datesale');
        if (request('price')) {
            $sales->totalprice = request('price') * request('productquantity') - request('discount');
        } else {
            $sales->totalprice = $product->productprice * request('productquantity') - request('discount');
        }
        $sales->payment_id = request('payment_id');
        $sales->bankname = request('bankname');
        $sales->checknumber = request('checknumber');
        $sales->exchangedate = request('exchangedate');

        // Save the sales record
        $sales->save();


        $account = accounts::where('name', $sales->customer->name)->first();

        if ($sales->payment->name == 'مؤجل') {
            if ($account) {
                $account->accountbalance -= $sales->totalprice;
                $account->save();
            } else {
                // Create a new account
                $account = new accounts;
                $account->name = $sales->customer->name;
                $account->creditorordebtor = 1;
                $account->accountbalance = -$sales->totalprice;
                $account->save();
            }
        }
        // Redirect with success message
        return redirect()->route('sales.index')->with('success', 'تمت إضافة المبيعات بنجاح');
    }

    public function destroy()
    {
        sales::findOrFail(request()->id)->delete();
        return redirect()->route('sales.index')->with('success', 'تم حذف  المبيعات بنجاح');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Perform the search query using your breeds model
        $sales = sales::whereHas('customer', function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
            ->orwhereHas('payment', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orwhereHas('products', function ($query) use ($search) {
                $query->where('productname', 'like', '%' . $search . '%');
            })
            ->orWhere('created_at', 'like', '%' . $search . '%')
            ->orWhere('datesale', 'like', '%' . $search . '%')

            ->get();

        return view('sales.index', ['sales' => $sales]);
    }
    public function export()
    {
        $filename = 'sales' . now()->format('YmdHis') . '.xlsx';

        return Excel::download(new salesExport(), $filename);
    }

    public function import(Request $request)
    {
        // $filename = 'cows' . now()->format('YmdHis') . '.xlsx';

        $request->validate(
            [
                'file' => 'required|mimes:xlsx',
            ],
            [
                'file.required' => 'ملف  المبيعات مطلوب',
                'file.mimes' => ' يجب ان يكون نوع الملف xlsx',
            ]
        );

        try {
            Excel::import(new salesimport(), $request->file);
            return redirect()->back()->with('success', 'تم استيراد البيانات بنجاح.');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء استيراد البيانات. يرجى التحقق من تنسيق الملف والمحاولة مرة أخرى.');
        }
    }
}
