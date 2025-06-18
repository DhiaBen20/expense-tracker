@use('App\Models\Category')
@use('Illuminate\Support\Facades\Auth')

@php
$categories = Category::select("id", "name")->where("user_id", Auth::id())->get();
@endphp

<x-layouts.app :title="__('Create Transactions')">
    <flux:heading size="xl" level="1">Create Transaction</flux:heading>
    <flux:text class="mt-2 mb-6 text-base">
        Here you can create a new transaction, click save when your done.
    </flux:text>

    <flux:separator variant="subtle" />

    <form action={{ route('transactions.store') }} method="post" class="space-y-6 mt-6 max-w-xl">
        @csrf

        <flux:field>
            <flux:label>Category</flux:label>
            <flux:select name="category_id" placeholder="Choose category">
                @foreach ($categories as $category)
                    <flux:select.option
                        :value="$category->id"
                        :selected="old('category_id') == $category->id"
                    >
                        {{ $category->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>
            <flux:error name="category_id" />
        </flux:field>

        <flux:field>
            <flux:label>Amount</flux:label>
            <flux:input name="amount" :value="old('amount')" />
            <flux:error name="amount" />
        </flux:field>

        <flux:field>
            <flux:label>Description</flux:label>
            <flux:textarea name="description">{{ old('description') }}</flux:textarea>
            <flux:error name="description" />
        </flux:field>

        <flux:field>
            <flux:label>Date</flux:label>
            <flux:input type="date" name="date" :value="old('date')" />
            <flux:error name="date" />
        </flux:field>

        

        <flux:button type="subit" variant="primary">Save</flux:button>
    </form>
</x-layouts.app>
