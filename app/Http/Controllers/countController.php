<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\cow;
use App\Models\milks;
use App\Models\sales;
use App\Models\breeds;
use App\Models\cowbirth;
use App\Models\expenses;
use App\Models\medicines;
use App\Models\purchases;
use Illuminate\Http\Request;
use App\Models\totalpriceforallmonth;
use Illuminate\Support\Facades\Session;

class countController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('permission:create-dashboard|edit-dashboard|delete-dashboard', ['only' => ['index', 'show']]);
    //     $this->middleware('permission:create-dashboard', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:edit-dashboard', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:delete-dashboard', ['only' => ['destroy']]);
    // }
    public function index()
    {


        $targetDate = Carbon::now()->subDays(50);
        $cowbirth = cowbirth::whereDate('dateofbirth', '=', $targetDate->toDateString())->get();
        $joinedMessages2 = '';

        foreach ($cowbirth as $cowbirt) {
            $cowNumber = $cowbirt->cowse2->cownumber;
            $successcowbirth = "البقرة رقم $cowNumber اكملت 50 يومًا على الولادة";
            $joinedMessages2 .= $successcowbirth . '<br>';
        }
        Session::flash('success-toob-cowbirth', $joinedMessages2);





        $breedDate = Carbon::now()->subDays(40);
        $breeds = breeds::whereDate('breedingdate', '=', $breedDate->toDateString())->get();

        // Initialize an empty string to store the success messages
        $joinedMessages = '';

        foreach ($breeds as $breed) {
            $cowNumber = $breed->cowse->cownumber;
            $successbreeds = "البقرة رقم $cowNumber اكملت 40 يومًا على التلقيح";

            // Concatenate the new success message to the existing string with a line break
            $joinedMessages .= $successbreeds . '<br>';
        }

        // Store the joined messages in the session flash
        Session::flash('success-toob-breed', $joinedMessages);







        $breedruselt = Carbon::now()->subDays(150);
        $result = breeds::where('result', 'حامل')
            ->whereDate('pregnancyhistory', '=', $breedruselt->toDateString())
            ->get();
        $joinedMessages3 = '';

        foreach ($result as $breedruselts) {
            $cowNumber = $breedruselts->cowse->cownumber;
            $successresult = "البقرة رقم  $cowNumber اكملت 150 يوم على نتيجة التلقيح ";
            // Concatenate the new success message to the existing string with a line break
            $joinedMessages3 .= $successresult . '<br>';
        }

        // Store the joined messages in the session flash
        Session::flash('success-bottom-breed', $joinedMessages3);






        $check = Carbon::now()->subDays(1);
        $purchases = purchases::whereDate('exchangedate', '=', $check->toDateString())
            ->get();
        $joinedMessages4 = '';

        foreach ($purchases as $purchasess) {
            $check = $purchasess->checknumber;
            $successresult = " تاريخ صرف شيك المشتريات رقم $check غدا";
            // Concatenate the new success message to the existing string with a line break
            $joinedMessages4 .= $successresult . '<br>';
        }

        // Store the joined messages in the session flash
        Session::flash('success-bottom-right', $joinedMessages4);


        $check2 = Carbon::now()->subDays(1);
        $sales = sales::whereDate('exchangedate', '=', $check2->toDateString())
            ->get();
        $joinedMessages5 = '';

        foreach ($sales as $sale) {
            $check2 = $sale->checknumber;
            $successresult = " تاريخ صرف شيك المبيعات رقم $check2 غدا";
            // Concatenate the new success message to the existing string with a line break
            $joinedMessages5 .= $successresult . '<br>';
        }

        // Store the joined messages in the session flash
        Session::flash('success-bottom-rr', $joinedMessages5);








        $currentMonth = Carbon::now()->format('m');

        $cowCount = cow::count();
        $totalpurchaseprice = cow::sum('purchasingprice');
        $totalsellprice = cow::sum('expectedsaleprice');
        $totaldailyexpenses = cow::sum('dailyexpense');
        $totalprice = $totalsellprice - ($totalpurchaseprice + $totaldailyexpenses);


        $totalpurchasepricemonth = cow::whereMonth('created_at', $currentMonth)->sum('purchasingprice');
        $totalsellpricemonth = cow::whereMonth('created_at', $currentMonth)->sum('expectedsaleprice');
        $totaldailyexpensesmonth = cow::whereMonth('created_at', $currentMonth)->sum('dailyexpense');
        $totalpricemonth = $totalsellpricemonth - ($totalpurchasepricemonth + $totaldailyexpensesmonth);


        $morningSum = milks::sum('morningamount');
        $noonSum = milks::sum('noonamount');
        $afternoonSum = milks::sum('afternoonamount');

        $totalmilk = $morningSum + $noonSum + $afternoonSum;


        $morningSuminmonth = milks::whereMonth('created_at', $currentMonth)->sum('morningamount');
        $noonSuminmonth = milks::whereMonth('created_at', $currentMonth)->sum('noonamount');
        $afternoonSuminmonth = milks::whereMonth('created_at', $currentMonth)->sum('afternoonamount');


        $totalmilkinmonth = $morningSuminmonth + $noonSuminmonth + $afternoonSuminmonth;

        $totalpurchases = purchases::sum('totalprice');
        $totalpurchasesmonth = purchases::whereMonth('created_at', $currentMonth)->sum('totalprice');
        $totalexpenses = expenses::sum('amount');
        $totalexpensesmonth = expenses::whereMonth('created_at', $currentMonth)->sum('amount');
        $totalsales = sales::sum('totalprice');
        $totalsalesmonth = sales::whereMonth('created_at', $currentMonth)->sum('totalprice');
        $grossproduct =  $totalsales - ($totalpurchases + $totalexpenses);
        $grossproductmonth =  $totalsalesmonth - ($totalpurchasesmonth + $totalexpensesmonth);


        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');

      if (Carbon::now()->isLastOfMonth()) {
            // Check if a record for the current year and month already exists
            $existingRecord = totalpriceforallmonth::where('year', $currentYear)
                                                   ->where('month', $currentMonth)
                                                   ->first();
            // If no record exists, create a new one
            if (!$existingRecord) {
                totalpriceforallmonth::create([
                    'year' => $currentYear,
                    'month' => $currentMonth,
                    'totalprice' => $grossproductmonth
                ]);
            }
        }
    

        return view('dashboard', compact(
            'cowCount',
            'totalpurchaseprice',
            'totalsellprice',
            'totaldailyexpenses',
            'totalpurchasepricemonth',
            'totalsellpricemonth',
            'totaldailyexpensesmonth',
            'totalprice',
            'totalpricemonth',
            'totalmilk',
            'totalmilkinmonth',
            'totalpurchases',
            'totalpurchasesmonth',
            'totalexpenses',
            'totalexpensesmonth',
            'totalsales',
            'totalsalesmonth',
            'grossproduct',
            'grossproductmonth',
        ));
    }
}
