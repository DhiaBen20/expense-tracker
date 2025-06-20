<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BudgetController extends Controller
{
    public function index(): View
    {
        return view('budgets.index', ['budgets' => Auth::user()->budgets]);
    }

    public function create(): View
    {
        return view('budgets.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'amount' => ['required', 'integer', 'min:0'],
            'month' => ['required', 'integer', 'between:1,12'],
            'year' => ['required', 'date_format:Y'],
        ]);

        if ($this->exists($request->year, $request->month)) {
            return back()->withInput()->withErrors([
                'year' => "You can't duplicate buget for the same year and month",
            ]);
        }

        Budget::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'month' => $request->month,
            'year' => $request->year,
        ]);

        return redirect()->route('budgets.index')
            ->with('success', 'Budget created successfuly.');
    }

    public function edit(Budget $budget): View
    {
        Gate::authorize('manage-budget', $budget);

        return view('budgets.edit', ['budget' => $budget]);
    }

    public function update(Request $request, Budget $budget): RedirectResponse
    {
        Gate::authorize('manage-budget', $budget);

        $request->validate([
            'amount' => ['required', 'integer', 'min:0'],
            'month' => ['required', 'integer', 'between:1,12'],
            'year' => ['required', 'date_format:Y'],
        ]);

        if ($this->exists($request->year, $request->month, $budget)) {
            return back()->withInput()->withErrors([
                'year' => "You can't duplicate buget for the same year and month",
            ]);
        }

        $budget->update([
            'amount' => $request->amount,
            'month' => $request->month,
            'year' => $request->year,
        ]);

        return redirect()->route('budgets.index')
            ->with('success', 'Budget updated successfuly.');
    }

    protected function exists(string|int $year, string|int $month, ?Budget $budget = null): bool
    {
        $query = Budget::where('user_id', Auth::id())
            ->where('year', $year)
            ->where('month', $month);

        if ($budget) {
            $query->where('id', '<>', $budget->id);
        }

        return $query->exists();
    }
}
