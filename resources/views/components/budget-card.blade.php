@props(["budget", "expenses"])


@if ($budget)
    @php
    $monthString = now()->month($budget->month)->format("F");
    $formattedBudget = Number::currency($budget->amount, in:'usd');

    $expensesPercent = -1 * ($expenses / $budget->amount);
    @endphp

    <div class="mt-8">
        <h2 class="mb-3 font-bold text-xl">Budget</h2>
        <x-card>
            <div class="flex justify-between items-center gap-8">
                <div>
                    <p>Budget for {{ $monthString }} {{ $budget->year }}</p>
                    <p class="text-xl font-bold mt-4">{{ $formattedBudget }}</p>
                </div>
                <p @class([
                    "text-gl font-bold" => true,
                    "text-green-400" => $expensesPercent<= .4,
                    "text-amber-400" => $expensesPercent> .4 && $expensesPercent<= .8,
                    "text-red-600" => $expensesPercent> .8 && $expensesPercent<= 1,
                ])>{{Number::currency($budget->amount - (-$expenses), in:'usd')}} Remaining</p>
            </div>
        </x-card>
    </div>
@else
    <p class="mt-8 text-neutral-400">You have no budget set for the current month.</p>
@endif