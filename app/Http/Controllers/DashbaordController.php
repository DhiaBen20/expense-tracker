<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashbaordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): View
    {
        assert(Auth::user() instanceof User);

        $currentMonthRange = [
            now()->startOfMonth()->toDateString(),
            now()->endOfMonth()->toDateString(),
        ];

        $summary = Transaction::select(
            DB::raw('sum(amount) as balance'),
            DB::raw('sum(case when amount > 0 then amount else 0 end) as income'),
            DB::raw('sum(case when amount < 0 then amount else 0 end) as expenses'),
        )
            ->whereBelongsTo(Auth::user())
            ->whereBetween('date', $currentMonthRange)
            ->first();

        $incomesQuery = Transaction::where('amount', '>', 0)->whereBetween('date', $currentMonthRange)->limit(10);
        $expensesQuery = Transaction::where('amount', '<', 0)->whereBetween('date', $currentMonthRange)->limit(10);

        [$incomes, $expenses] = $incomesQuery->union($expensesQuery->getQuery())
            ->orderBy('date', 'desc')
            ->get()
            ->partition(function (Transaction $transaction) {
                return $transaction->amount > 0;
            });

        $budget = Budget::whereBelongsTo(Auth::user())
            ->where('year', now()->year)
            ->where('month', now()->month)
            ->first();

        return view('dashboard', [
            'summary' => $summary,
            'incomes' => $incomes,
            'expenses' => $expenses,
            'budget' => $budget,
        ]);
    }
}
