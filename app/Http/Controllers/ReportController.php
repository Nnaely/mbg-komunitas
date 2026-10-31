<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Report;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        return view('reports.index', [
            'schools' => School::query()->orderBy('name')->get(['id', 'name']),
            'reports' => $request->user()->reports()->with('school')->latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school_id' => ['required', 'integer', 'exists:schools,id'],
            'description' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        $request->user()->reports()->create($validated);

        return redirect()
            ->route('reports.index')
            ->with('status', 'Laporan berhasil dikirim.');
    }

    public function inbox(): View
    {
        return view('reports.inbox', [
            'reports' => Report::with(['school', 'reporter'])
                ->latest()
                ->paginate(15),
        ]);
    }

    public function show(Report $report): View
    {
        return view('reports.show', [
            'report' => $report->load(['school', 'reporter']),
        ]);
    }
}
