<?php

namespace App\Http\Controllers;

use App\Models\IndonesiaProvince;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $provinces = IndonesiaProvince::withCount('indonesiaCities')
            ->get();

        return \view('home', compact('provinces'));
    }
}
