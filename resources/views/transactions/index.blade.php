<x-layouts.app :title="__('Transactions')">
    <div class="flex items-center justify-between flex-wrap mb-6 gap-6">
        <div class="md:max-w-1/2">
            <flux:heading size="xl" level="1">Transactions</flux:heading>
            <flux:text class="mt-2 text-base">
                Here you can manage your transaction, you can create new ones, edit or delete existing ones.
            </flux:text>
        </div>
        <flux:button :href="route('transactions.create')" variant="primary">Create Transaction</flux:button>
    </div>

    <flux:separator variant="subtle" />

    @if (count($transactions) === 0)
        <p class="mt-6 text-neutral-400">there is no transactions yet</p>
    @else
        <div class="mt-6 grid gap-4 sm:grid-cols-2 md:grid-cols-3">
            @foreach ($transactions as $transaction)
                <x-card>
                    <div class="flex flex-col">
                        <div class="font-semibold flex justify-between items-start">
                            {{ $transaction->category->name }}
                            <flux:dropdown>
                        <flux:button icon="ellipsis-horizontal" variant="ghost" size="sm"></flux:button>
                        <flux:menu>
                            <flux:menu.item :href="route('transactions.edit', $transaction)">Edit</flux:menu.item>
                    
                            <form method="post" action={{ route('transactions.destroy', $transaction) }}>
                                @method('delete')
                                @csrf
                                <flux:menu.item as="button" type="submit">Delete</flux:menu.item>
                            </form>
                        </flux:menu>
                    </flux:dropdown>
                        </div>
                        <span class="text-zinc-400 text-sm">{{ $transaction->date->toFormattedDateString() }}</span>
                    </div>
                    <p class="text-zinc-300 mt-2">{{ $transaction->description }}</p>
                    <p
                        @class([
                            "text-xl font-bold mt-2 text-right",
                            "text-green-500" => $transaction->amount >= 0,
                            "text-red-600" => $transaction->amount < 0,
                        ])
                    >
                        {{ Number::currency($transaction->amount, in:"usd") }}
                    </p>
                </x-card>
            @endforeach
        </div>
    @endif
</x-layouts.app>
