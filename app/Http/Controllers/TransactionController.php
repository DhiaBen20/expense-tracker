<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('transactions.index', [
            'transactions' => Auth::user()->transactions->load('category'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'description' => ['required', 'min:3', 'max:255'],
            'amount' => ['required', 'integer'],
            'category_id' => ['required', 'exists:categories,id'],
            'date' => ['required', 'date'],
        ]);

        Transaction::create([
            'description' => $request->description,
            'amount' => $request->amount,
            'date' => $request->date,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('transactions.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction): View
    {
        return view('transactions.edit', ['transaction' => $transaction]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        Gate::authorize('manage-transaction', $transaction);

        $request->validate([
            'description' => ['required', 'min:3', 'max:255'],
            'amount' => ['required', 'integer'],
            'category_id' => ['required', 'exists:categories,id'],
            'date' => ['required', 'date'],
        ]);

        $transaction->update([
            'description' => $request->description,
            'amount' => $request->amount,
            'category_id' => $request->category_id,
            'date' => $request->date,
        ]);

        return redirect()->route('transactions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction): RedirectResponse
    {
        Gate::authorize('manage-transaction', $transaction);

        $transaction->delete();

        return redirect()->route('transactions.index');
    }
}
