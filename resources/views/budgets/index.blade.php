<x-layouts.app :title="__('Budgets')">
    <div class="flex items-center justify-between flex-wrap mb-6 gap-6">
        <div class="md:max-w-1/2">
            <flux:heading size="xl" level="1">Budgets</flux:heading>
            <flux:text class="mt-2 text-base">
                Here you can manage your budgets, you can create new ones, edit existing ones.
            </flux:text>
        </div>
        <flux:button :href="route('budgets.create')" variant="primary">Create Budget</flux:button>
    </div>

    <flux:separator variant="subtle" />

    @session("success")
        <div class="mt-6 border rounded-md px-6 py-3 border-emerald-700 bg-emerald-800 text-emerald-100">
            {{ $value }}
        </div>
    @endsession

    @if (count($budgets) === 0)
        <p class="mt-6 text-neutral-400">there is no budgets yet</p>
    @else
        <div class="mt-6">
            <table class="w-full border-collapse bg-neutral-700 [&_th]:text-left [&_th]:py-1.5 [&_td]:py-1.5 [&_th]:px-3 [&_td]:px-3 [&_th]:border-2 [&_td]:border-2 [&_th]:border-neutral-600 [&_td]:border-neutral-600">
                <colgroup>
                    <col class="w-1/4"/>
                    <col class="w-1/4"/>
                    <col class="w-1/4"/>
                    <col class="w-1/4"/>
                </colgroup>
                <thead>
                    <tr>
                        <th>Year</th>
                        <th>month</th>
                        <th>amount</th>
                        <th><span class="sr-only">Edit</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($budgets as $budget)
                    <tr>
                        <td>{{ $budget->year }}</td>
                        <td>{{ now()->month($budget->month)->format("F") }}</td>
                        <td>{{ Number::currency($budget->amount, in:"usd") }}</td>
                        <td class="text-right">
                            <a href={{ route('budgets.edit', $budget) }}>Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-layouts.app>
