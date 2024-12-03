<?php

namespace App\Http\Controllers;

use App\Models\cow;
use App\Models\milks;
use App\Models\breeds;
use App\Models\cowbirth;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;
use App\Models\medicines;
use Illuminate\View\View;
use App\Exports\CowExport;
use App\Imports\Cowimport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class cowController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:create-cow|edit-cow|delete-cow', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-cow', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-cow', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-cow', ['only' => ['destroy']]);
    }
    public function index()
    {
        $cow = cow::where('status', 1)->get();

        return view('cow.index', compact('cow'));
    }

    public function update($id, Request $request)
    {
        $request->validate(
            [
                'cownumber' => 'required|unique:cows,cownumber,' . $id,
                'status' => 'required',
                // 'farmentrydate' => 'required|date',
                // 'weight' => 'required|numeric',
                // 'purchasingprice' => 'required|numeric',
                // 'expectedsaleprice' => 'required|numeric',
                // 'dailyexpense' => 'required|numeric',
            ],
            [
                'cownumber.unique' => 'رقم البقرة موجود من قبل',
                'cownumber.required' => 'رقم البقرة
                مطلوب',
                'status.required' => 'حالة البقرة
                مطلوب',
                'farmentrydate.required' => 'تاريخ اد
                خال البقرة
                مطلوب',
                'farmentrydate.date' => 'تاريخ اد
                خال البقرة
                مطلوب',
                'purchasingprice.required' => 'سعر الشراء
                مطلوب',
                'expectedsaleprice.required' => 'سعر البيع
                مطلوب',
                'dailyexpense.required' => 'اجمالي المص
                روفات
                مطلوب',
                'weight' => 'الوزن مطلوب',

            ]
        );
        $cow = cow::find($id);
        $cow->cownumber = request('cownumber');
        $cow->mothernumber = request('mothernumber');
        $cow->status = request('status');
        $cow->farmentrydate = request('farmentrydate');
        $cow->weight = request('weight');
        $cow->purchasingprice = request('purchasingprice');
        $cow->expectedsaleprice = request('expectedsaleprice');
        $cow->dailyexpense = request('dailyexpense');
        $cow->weaningdate = request('weaningdate');
        $cow->birthdate = request('birthdate');
        if (request()->hasFile('image')) {
            $file = request()->file('image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move('images/', $filename);
            $cow->image = $filename;
        }
        $cow->save();

        if (empty($cow->qrcode)) {
            $data = route('cow.detailsqr', ['cowId' => $cow->id]);

            // Set the path where you want to save the QR code image
            $path = public_path('qrcodes/');

            // Ensure the directory exists; create it if not
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // Generate 2D barcode (QR code)
            $barcode2D = new DNS2D();
            $barcode2D->setStorPath($path);
            $qrCodePath = $barcode2D->getBarcodePNGPath($data, 'QRCODE', 3, 3);


            // Save the QR code path to the database
            $cow->qrcode = basename($qrCodePath);
            $cow->save();
        }



        return redirect()->route('cow.index')->with('success', 'تم تعديل البقرة بنجاح');
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'cownumber' => 'required|unique:cows,cownumber',
                'status' => 'required',
                // 'farmentrydate' => 'required|date',
                // 'weight' => 'required|numeric',
                // 'purchasingprice' => 'required|numeric',
                // 'expectedsaleprice' => 'required|numeric',
                // 'dailyexpense' => 'required|numeric',
            ],
            [
                'cownumber.unique' => 'رقم البقرة موجود من قبل',
                'cownumber.required' => 'رقم البقرة
                مطلوب',
                'status.required' => 'حالة البقرة
                مطلوب',
                'farmentrydate.required' => 'تاريخ اد
                خال البقرة
                مطلوب',
                'farmentrydate.date' => 'تاريخ اد
                خال البقرة
                مطلوب',
                'purchasingprice.required' => 'سعر الشراء
                مطلوب',
                'expectedsaleprice.required' => 'سعر البيع
                مطلوب',
                'dailyexpense.required' => 'اجمالي المص
                روفات
                مطلوب',
                'weight' => 'الوزن مطلوب',

            ]
        );
        $cow = new  cow();
        $cow->cownumber = request('cownumber');
        $cow->mothernumber = request('mothernumber');
        $cow->status = request('status');
        $cow->farmentrydate = request('farmentrydate');
        $cow->weight = request('weight');
        $cow->purchasingprice = request('purchasingprice');
        $cow->expectedsaleprice = request('expectedsaleprice');
        $cow->dailyexpense = request('dailyexpense');
        $cow->weaningdate = request('weaningdate');
        $cow->birthdate = request('birthdate');
        if (request()->hasFile('image')) {
            $file = request()->file('image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move('images/', $filename);
            $cow->image = $filename;
        }
        $cow->save();
        // Set the data you want to encode in the QR code
        $data = route('cow.detailsqr', ['cowId' => $cow->id]);

        // Set the path where you want to save the QR code image
        $path = public_path('qrcodes/');

        // Ensure the directory exists; create it if not
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        // Generate 2D barcode (QR code)
        $barcode2D = new DNS2D();
        $barcode2D->setStorPath($path);
        $qrCodePath = $barcode2D->getBarcodePNGPath($data, 'QRCODE', 3, 3);


        // Save the QR code path to the database
        $cow->qrcode = basename($qrCodePath);
        $cow->save();


        return redirect()->route('cow.index')->with('success', 'تم اضافة البقرة بنجاح');
    }
    public function destroy()
    {
        cow::findOrFail(request()->id)->delete();
        return redirect()->route('cow.index')->with('success', 'تم حذف البقرة بنجاح');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Perform the search query using your Cow model
        $cows = cow::where('cownumber', 'like', '%' . $search . '%')
            ->orWhere('mothernumber', 'like', '%' . $search . '%')
            ->orWhere('farmentrydate', 'like', '%' . $search . '%')
            ->orWhere('weight', 'like', '%' . $search . '%')
            ->orWhere('purchasingprice', 'like', '%' . $search . '%')
            ->orWhere('expectedsaleprice', 'like', '%' . $search . '%')
            ->orWhere('dailyexpense', 'like', '%' . $search . '%')
            ->orWhere('status', 'like', '%' . $search . '%')
            ->orWhere('weaningdate', 'like', '%' . $search . '%')
            ->orWhere('birthdate', 'like', '%' . $search . '%')
            ->get();

        return view('cow.index', ['cow' => $cows]);
    }

    public function viewDetails($cowId)
    {
        $cow = cow::findOrFail($cowId); // Find the cow by ID, you may want to handle not found case differently

        $breeds = $cow->breeds;
        $medicines = $cow->medicines;
        $milks = $cow->milks;
        $cowbirth = $cow->cowbirth;

        $breeds2 = breeds::where('cownumber', $cow->id)->count();
        $medicines2 = medicines::where('cownumber', $cow->id)->count();
        $milks2 = milks::where('cownumber', $cow->id)->count();
        $cowbirth2 = cowbirth::where('mothernumber', $cow->id)->count();

        return view('cow.details', [
            'cow' => $cow,
            'breeds' => $breeds,
            'medicines' => $medicines,
            'milks' => $milks,
            'cowbirth' => $cowbirth,
            'breeds2' => $breeds2,
            'medicines2' => $medicines2,
            'milks2' => $milks2,
            'cowbirth2' => $cowbirth2,
        ]);
    }
    public function viewDetailsqr($cowId)
    {
        $cow = cow::findOrFail($cowId); // Find the cow by ID, you may want to handle not found case differently

        $breeds = $cow->breeds;
        $medicines = $cow->medicines;
        $milks = $cow->milks;
        $cowbirth = $cow->cowbirth;

        $breeds2 = breeds::where('cownumber', $cow->id)->count();
        $medicines2 = medicines::where('cownumber', $cow->id)->count();
        $milks2 = milks::where('cownumber', $cow->id)->count();
        $cowbirth2 = cowbirth::where('mothernumber', $cow->id)->count();

        return view('cow.detailsqr', [
            'cow' => $cow,
            'breeds' => $breeds,
            'medicines' => $medicines,
            'milks' => $milks,
            'cowbirth' => $cowbirth,
            'breeds2' => $breeds2,
            'medicines2' => $medicines2,
            'milks2' => $milks2,
            'cowbirth2' => $cowbirth2,
        ]);
    }


    public function export()
    {
        $filename = 'cows' . now()->format('YmdHis') . '.xlsx';

        return Excel::download(new CowExport(), $filename);
    }
    public function import(Request $request)
    {
        // $filename = 'cows' . now()->format('YmdHis') . '.xlsx';

        $request->validate(
            [
                'file' => 'required|mimes:xlsx',
            ],
            [
                'file.required' => 'ملف الابقار مطلوب',
                'file.mimes' => ' يجب ان يكون نوع الملف xlsx',

            ]
        );

        try {
            Excel::import(new Cowimport(), $request->file);
            return redirect()->back()->with('success', 'تم استيراد البيانات بنجاح.');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء استيراد البيانات. يرجى التحقق من تنسيق الملف والمحاولة مرة أخرى.');
        }
    }

    public function updateAllQRCodes()
    {
        // Fetch all cow data from the database
        $cows = cow::all();

        // Loop through each cow and update the QR code
        foreach ($cows as $cow) {
            $this->updateQRCode($cow);
        }

        // You may want to return a response indicating success or failure
        return response()->json(['message' => 'QR Codes updated successfully']);
    }

    private function updateQRCode($cow)
    {
        $data = route('cow.detailsqr', ['cowId' => $cow->id]);
        $path = public_path('qrcodes/');

        // Generate 2D barcode (QR code)
        $barcode2D = new DNS2D();
        $barcode2D->setStorPath($path);
        $qrCodePath = $barcode2D->getBarcodePNGPath($data, 'QRCODE', 3, 3);

        // Save the QR code path to the cow's record
        $cow->qrcode = basename($qrCodePath);
        $cow->save();
        
    }
}
