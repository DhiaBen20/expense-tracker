<x-layouts.app :title="__('Edit Transaction')">
    <flux:heading size="xl" level="1">Edit Transaction</flux:heading>
    <flux:text class="mt-2 mb-6 text-base">
        Here you can edit an existing transaction, click save when you're done.
    </flux:text>

    <flux:separator variant="subtle" />

    <form action={{ route('transactions.update', $transaction) }} method="post" class="space-y-6 mt-6 max-w-xl">
        @method("patch")
        @csrf

        <flux:field>
            <flux:label>Category</flux:label>
            <flux:select name="category_id" placeholder="Choose category">
                @foreach (\App\Models\Category::all() as $category)
                    <flux:select.option
                        :value="$category->id"
                        :selected="old('category_id') ? old('category_id') == $category->id : $transaction->category_id == $category->id"
                    >
                        {{ $category->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>
            <flux:error name="category_id" />
        </flux:field>

        <flux:field>
            <flux:label>Amount</flux:label>
            <flux:input name="amount" :value="old('amount') ?? $transaction->amount" />
            <flux:error name="amount" />
        </flux:field>

        <flux:field>
            <flux:label>Description</flux:label>
            <flux:textarea name="description">{{ old('description') ?? $transaction->description }}</flux:textarea>
            <flux:error name="description" />
        </flux:field>

        <flux:field>
            <flux:label>Date</flux:label>
            <flux:input type="date" name="date" :value="old('date') ?? $transaction->date" />
            <flux:error name="date" />
        </flux:field>

        

        <flux:button type="subit" variant="primary">Save</flux:button>
    </form>
</x-layouts.app>
