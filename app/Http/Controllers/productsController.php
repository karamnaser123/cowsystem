<?php

namespace App\Http\Controllers;

use App\Models\products;
use Illuminate\Http\Request;
use App\Exports\BreedsExport;
use App\Exports\productsExport;
use App\Imports\productsimport;
use Maatwebsite\Excel\Facades\Excel;

class productsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-product|edit-product|delete-product', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-product', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-product', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-product', ['only' => ['destroy']]);
    }
    public function index()
    {
        $products = products::all();
        return view('products.index', compact('products'));
    }
    public function update($id, Request $request)
    {
        $request->validate(
            [
                'productname' => 'required|unique:products,productname,' . $id,
                'productprice' => 'required',
                'quantity' => 'required',

            ],
            [
                'productname.required' => ' اسم المنتج
            مطلوب',
                'productname.unique' => 'هذا الاسم موجود بالفعل',
                'productprice.required' => ' السعر مطلوب ',
                'quantity.required' => ' الكمية مطلوبة ',
                'productimage.required' => 'صورة المنتج مطلوبة'


            ]
        );
        $product = products::find($id);
        $product->productname = request('productname');
        $product->productprice = request('productprice');
        $product->quantity = request('quantity');
        if (request()->hasFile('productimage')) {
            $file = request()->file('productimage');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move('images/products/', $filename);
            $product->productimage = $filename;
        }
        $product->save();

        return redirect()->route('products.index')->with('success', 'تم تعديل المنتج بنجاح');
    }




    public function store(Request $request)
    {
        $request->validate(
            [
                'productname' => 'required|unique:products,productname',
                'productprice' => 'required',
                'quantity' => 'required',

            ],
            [
                'productname.required' => ' اسم المنتج
            مطلوب',
                'productname.unique' => 'هذا الاسم موجود بالفعل',
                'productprice.required' => ' السعر مطلوب ',
                'quantity.required' => ' الكمية مطلوبة ',
                'productimage.required' => 'صورة المنتج مطلوبة'


            ]
        );


        $product = new  products();
        $product->productname = request('productname');
        $product->productprice = request('productprice');
        $product->quantity = request('quantity');
        if (request()->hasFile('productimage')) {
            $file = request()->file('productimage');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move('images/products/', $filename);
            $product->productimage = $filename;
        }
        $product->save();

        return redirect()->route('products.index')->with('success', 'تم اضافة المنتح بنجاح');
    }
    public function destroy()
    {
        products::findOrFail(request()->id)->delete();
        return redirect()->route('products.index')->with('success', 'تم حذف  المنتج بنجاح');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Perform the search query using your breeds model
        $suppliers = products::where('productname', 'like', '%' . $search . '%')
            ->orWhere('productprice', 'like', '%' . $search . '%')
            ->get();

        return view('products.index', ['suppliers' => $suppliers]);
    }
    public function export()
    {
        $filename = 'products' . now()->format('YmdHis') . '.xlsx';

        return Excel::download(new productsExport(), $filename);
    }
    public function import(Request $request)
    {
        // $filename = 'cows' . now()->format('YmdHis') . '.xlsx';

        $request->validate(
            [
                'file' => 'required|mimes:xlsx',
            ],
            [
                'file.required' => 'ملف  المنتجات مطلوب',
                'file.mimes' => ' يجب ان يكون نوع الملف xlsx',
            ]
        );

        try {
            Excel::import(new productsimport(), $request->file);
            return redirect()->back()->with('success', 'تم استيراد البيانات بنجاح.');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء استيراد البيانات. يرجى التحقق من تنسيق الملف والمحاولة مرة أخرى.');
        }
    }
}