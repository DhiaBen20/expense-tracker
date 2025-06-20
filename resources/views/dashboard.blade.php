<x-layouts.app :title="__('Dashboard')">
    <x-dashboard-summary :$summary />

    <x-budget-card :$budget :expenses="$summary->expenses" />

    <div class="mt-8">
        <h2 class="mb-3 font-bold text-xl">Recent Incomes</h2>

        @if (count($incomes) === 0)
        <p class="text-zinc-400">No incomes created this month yet.</p>
        @else
            <x-stacked-list>
                @foreach ($incomes as $transaction)
                    <x-stacked-list-item class="flex justify-between items-center gap-4">
                        <div class="space-x-2">
                            <span class="text-zinc-300">{{ $transaction->date->toFormattedDateString() }}</span>
                            <span>-</span>
                            <span>{{ $transaction->description }}</span>
                        </div>
                        <div class="font-bold">{{ Number::currency($transaction->amount, in:"usd") }}</div>
                    </x-stacked-list-item>
                @endforeach
            </x-stacked-list>
        @endif

    </div>

    <div class="mt-8">
        <h2 class="mb-3 font-bold text-xl">Recent Expenses</h2>
        @if (count($expenses) === 0)
        <p class="text-zinc-400">No expenses created this month yet.</p>
        @else
            <x-stacked-list>
                @foreach ($expenses as $transaction)
                    <x-stacked-list-item class="flex justify-between items-center gap-4">
                        <div class="space-x-2">
                            <span class="text-zinc-300">{{ $transaction->date->toFormattedDateString() }}</span>
                            <span>-</span>
                            <span>{{ $transaction->description }}</span>
                        </div>
                        <div class="font-bold">{{ Number::currency($transaction->amount, in:"usd") }}</div>
                    </x-stacked-list-item>
                @endforeach
            </x-stacked-list>
        @endif

    </div>
</x-layouts.app>
