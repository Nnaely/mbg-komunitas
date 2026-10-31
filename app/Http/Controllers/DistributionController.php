<?php

namespace App\Http\Controllers;

use App\Models\Distribution;
use Illuminate\Contracts\View\View;

class DistributionController extends Controller
{
    public function index(): View
    {
        $distributions = Distribution::with('school')
            ->orderByDesc('distribution_date')
            ->get();

        return view('distributions.index', compact('distributions'));
    }
}
