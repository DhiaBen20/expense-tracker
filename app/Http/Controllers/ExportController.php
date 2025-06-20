<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use League\Csv\Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function __invoke(): StreamedResponse
    {
        return response()->streamDownload(function () {
            $writer = Writer::createFromPath('php://output', 'w');

            $writer->insertOne(['Description', 'Category', 'Date', 'Type', 'Amount']);

            assert(Auth::user() instanceof User);

            $lines = Transaction::with('category')
                ->whereBelongsTo(Auth::user())
                ->get()
                ->map(function (Transaction $transaction) {
                    assert($transaction->category instanceof Category);

                    return [
                        $transaction->description,
                        $transaction->category->name,
                        $transaction->date->format('Y M d'),
                        $transaction->amount < 0 ? 'Expense' : 'Income',
                        $transaction->amount,
                    ];
                });

            $writer->insertAll($lines);
        }, 'transactions.csv');
    }
}
