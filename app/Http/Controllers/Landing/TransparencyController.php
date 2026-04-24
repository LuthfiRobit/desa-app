<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use App\Models\Profile;
use Illuminate\Http\Request;

class TransparencyController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        $finances = Finance::orderBy('year', 'desc')->get();

        // Grouping data for charts/tables if needed
        $income = Finance::where('type', 'income')->get();
        $expenditure = Finance::where('type', 'expense')->get();

        return view('landing.transparansi', compact('profile', 'income', 'expenditure'));
    }
}
