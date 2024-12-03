<?php

namespace App\Http\Controllers;

use App\Models\breeds;
use App\Exports\CowExport;
use Illuminate\Http\Request;
use App\Exports\BreedsExport;
use App\Imports\Breedsimport;
use Maatwebsite\Excel\Facades\Excel;

class breedsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-breed|edit-breed|delete-breed', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-breed', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-breed', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-breed', ['only' => ['destroy']]);
    }
    public function index()
    {
        $breeds = breeds::all();
        return view('breeds.index', compact('breeds'));
    }
    public function update($id, Request $request)
    {
        $request->validate(
            [
                'cownumber' => 'required',
                // 'breedingdate' => 'required|date',
                // 'breedingtype' => 'required',
                // 'breedingstatus' => 'required',
                // 'cost' => 'required|numeric',
                // 'examinationdate' => 'required|date',
            ],
            [
                'cownumber.unique' => 'رقم البقرة موجود من قبل',
                'cownumber.required' => 'رقم البقرة
                مطلوب',
                // 'breedingdate.required' => 'تاريخ التلقيح مطلوب',
                // 'breedingtype.required' => 'نوع التلقيح مطلوب',
                // 'breedingstatus.required' => 'حالة التلقيح مطلوب',
                // 'expectedbirthdate.required' => 'تاريخ الميلاد المتوقع مطلوب',
                // 'cost.required' => ' مقدار التكلفة مطلوب',
                // 'cost.numeric' => ' مقدار التكلفة يجب ان يكون رقم',
                // 'examinationdate.required' => 'تاريخ الفحص مطلوب',
                // 'result.required' => ' نتيجة الفحص مطلوب',
            ]
        );
        $breeds = breeds::find($id);
        $breeds->cownumber = request('cownumber');
        $breeds->breedingdate = request('breedingdate');
        $breeds->breedingtype = request('breedingtype');
        $breeds->breedingstatus = request('breedingstatus');
        $breeds->cost = request('cost');
        $breeds->pollinationby = request('pollinationby');
        $breeds->examinationdate = request('examinationdate');
        $breeds->save();

        return redirect()->route('breeds.index')->with('success', 'تم تعديل التلقيح بنجاح');
    }

    public function update2($id, Request $request)
    {
        // $request->validate(
        //     [

        //         'expectedbirthdate' => 'required',
        //         'result' => 'required',
        //         'note' => 'required',
        //     ],
        //     [
        //         'expectedbirthdate.required' => 'تاريخ التلقيح مطلوب',
        //         'result.required' => 'نوع التلقيح مطلوب',
        //         'note.required' => 'حالة التلقيح مطلوب',

        //     ]
        // );
        $breeds = breeds::find($id);
        $breeds->expectedbirthdate = request('expectedbirthdate');
        $breeds->result = request('result');
        if (request('result') == 'حامل') {
            $breeds->pregnancyhistory = now()->format('Y-m-d');
        }
        $breeds->note = request('note');
        $breeds->save();

        return redirect()->route('breeds.index')->with('success', 'تم نتيجة الفحص  بنجاح');
    }


    public function store(Request $request)
    {
        $request->validate(
            [
                'cownumber' => 'required',
                // 'breedingdate' => 'required|date',
                // 'breedingtype' => 'required',
                // 'breedingstatus' => 'required',
                // 'cost' => 'required|numeric',
                // 'examinationdate' => 'required|date',
            ],
            [
                'cownumber.unique' => 'رقم البقرة موجود من قبل',
                'cownumber.required' => 'رقم البقرة
                مطلوب',
                // 'breedingdate.required' => 'تاريخ التلقيح مطلوب',
                // 'breedingtype.required' => 'نوع التلقيح مطلوب',
                // 'breedingstatus.required' => 'حالة التلقيح مطلوب',
                // 'expectedbirthdate.required' => 'تاريخ الميلاد المتوقع مطلوب',
                // 'cost.required' => ' مقدار التكلفة مطلوب',
                // 'cost.numeric' => ' مقدار التكلفة يجب ان يكون رقم',
                // 'examinationdate.required' => 'تاريخ الفحص مطلوب',
                // 'result.required' => ' نتيجة الفحص مطلوب',
            ]
        );
        $breeds = new  breeds();
        $breeds->cownumber = request('cownumber');
        $breeds->breedingdate = request('breedingdate');
        $breeds->breedingtype = request('breedingtype');
        $breeds->breedingstatus = request('breedingstatus');
        $breeds->expectedbirthdate = request('expectedbirthdate');
        $breeds->cost = request('cost');
        $breeds->pollinationby = request('pollinationby');
        $breeds->examinationdate = request('examinationdate');
        $breeds->result = request('result');
        $breeds->note = request('note');
        $breeds->save();

        return redirect()->route('breeds.index')->with('success', 'تم اضافة التلقيح بنجاح');
    }
    public function destroy()
    {
        breeds::findOrFail(request()->id)->delete();
        return redirect()->route('breeds.index')->with('success', 'تم حذف التلقيح بنجاح');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Perform the search query using your breeds model
        $breedss = breeds::whereHas('cowse', function ($query) use ($search) {
            $query->where('cownumber', 'like', '%' . $search . '%');
        })
            ->orWhere('breedingdate', 'like', '%' . $search . '%')
            ->orWhere('breedingtype', 'like', '%' . $search . '%')
            ->orWhere('breedingstatus', 'like', '%' . $search . '%')
            ->orWhere('expectedbirthdate', 'like', '%' . $search . '%')
            ->orWhere('cost', 'like', '%' . $search . '%')
            ->orWhere('pollinationby', 'like', '%' . $search . '%')
            ->get();

        return view('breeds.index', ['breeds' => $breedss]);
    }
    public function export()
    {
        $filename = 'breeds' . now()->format('YmdHis') . '.xlsx';

        return Excel::download(new BreedsExport(), $filename);
    }

    public function import(Request $request)
    {
        // $filename = 'cows' . now()->format('YmdHis') . '.xlsx';

        $request->validate(
            [
                'file' => 'required|mimes:xlsx',
            ],
            [
                'file.required' => 'ملف تلقيح الابقار مطلوب',
                'file.mimes' => ' يجب ان يكون نوع الملف xlsx',
            ]
        );

        try {
            Excel::import(new Breedsimport(), $request->file);
            return redirect()->back()->with('success', 'تم استيراد البيانات بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء استيراد البيانات. يرجى التحقق من تنسيق الملف والمحاولة مرة أخرى.');
        }
    }
}