<x-layouts.app :title="__('Create Categories')">
    <flux:heading size="xl" level="1">Create Category</flux:heading>
    <flux:text class="mt-2 mb-6 text-base">
        Here you can create a new category, click save when your done.
    </flux:text>

    <flux:separator variant="subtle" />

    <form action={{ route('categories.store') }} method="post" class="space-y-6 mt-6 max-w-xl">
        @csrf

        <flux:field>
            <flux:label>Name</flux:label>
            <flux:input name="name" />
            <flux:error name="name" />
        </flux:field>

        <flux:button type="subit" variant="primary">Save</flux:button>
    </form>
</x-layouts.app>
