<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\totalpriceforallmonth;

class totalpriceforallmonthController extends Controller
{
    public function index()
    {
       $totalprice = totalpriceforallmonth::all();

       return view('totalpriceforallmonth', compact('totalprice'));  
    }
}
