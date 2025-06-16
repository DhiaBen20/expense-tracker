<x-layouts.app :title="__('Edit Category')">
    <flux:heading size="xl" level="1">Edit Category</flux:heading>
    <flux:text class="mt-2 mb-6 text-base">
        Here you can edit new category, click save when you're done.
    </flux:text>

    <flux:separator variant="subtle" />

    <form action={{ route('categories.update', $category) }} method="post" class="space-y-6 mt-6 max-w-xl">
        @method('patch')
        @csrf

        <flux:field>
            <flux:label>Name</flux:label>
            <flux:input name="name" :value="$category->name" />
            <flux:error name="name" />
        </flux:field>

        <flux:button type="submit" variant="primary">Save</flux:button>
    </form>
</x-layouts.app>
