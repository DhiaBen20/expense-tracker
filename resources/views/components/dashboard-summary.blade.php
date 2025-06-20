@props(["summary"])

<div>
    <h2 class="mb-3 font-bold text-xl">Summary</h2>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
        <x-card>
            <h2 class="font-bold">Total Income</h2>
            <p class="text-2xl font-bold mt-2 text-green-600">{{ Number::currency($summary->income ?? 0, in:"usd") }}</p>
        </x-card>
        <x-card>
            <h2 class="font-bold">Total Expenses</h2>
            <p class="text-2xl font-bold mt-2 text-red-500">{{ Number::currency($summary->expenses ?? 0, in:"usd") }}</p>
        </x-card>
        <x-card>
            <h2 class="font-bold">Balance</h2>
            <p class="text-2xl font-bold mt-2">{{ Number::currency($summary->balance ?? 0, in:"usd") }}</p>
        </x-card>
    </div>
</div>