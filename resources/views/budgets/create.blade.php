@php
$months = [
    1 => 'January',
    2 => 'February',
    3 => 'March',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July',
    8 => 'August',
    9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December',
];
@endphp

<x-layouts.app :title="__('Create Budget')">
    <flux:heading size="xl" level="1">Create Budget</flux:heading>
    <flux:text class="mt-2 mb-6 text-base">
        Here you can create a new budget, click save when your done.
    </flux:text>

    <flux:separator variant="subtle" />

    <form action={{ route('budgets.store') }} method="post" class="space-y-6 mt-6 max-w-xl">
        @csrf

        <flux:field>
            <flux:label>Amount</flux:label>
            <flux:input name="amount" :value="old('amount')" />
            <flux:error name="amount" />
        </flux:field>

        <flux:field>
            <flux:label>Year</flux:label>
            <flux:input type="number" name="year" :value="old('year') ?? now()->year" />
            <flux:error name="year" />
        </flux:field>


        <flux:field>
            <flux:label>Month</flux:label>
            <flux:select name="month" placeholder="Choose a month">
                @foreach($months as $num => $name)
                    <flux:select.option
                        :value="$num"
                        :selected="old('month') ? old('month') == $num : now()->month == $num"
                    >
                        {{ $name }}
                    </flux:select.option>
                @endforeach
            </flux:select>
            <flux:error name="month" />
        </flux:field>        

        <flux:button type="subit" variant="primary">Save</flux:button>
    </form>
</x-layouts.app>
