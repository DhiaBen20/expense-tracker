<x-layouts.app :title="__('Categories')">
    <div class="flex items-center justify-between flex-wrap mb-6 gap-6">
        <div class="md:max-w-1/2">
            <flux:heading size="xl" level="1">Categories</flux:heading>
            <flux:text class="mt-2 text-base">
                Here you can manage your categories, you can create new ones, edit or delete existing ones.
            </flux:text>
        </div>
        <flux:button :href="route('categories.create')" variant="primary">Create Category</flux:button>
    </div>

    <flux:separator variant="subtle" />

    @if (count($categories) === 0)
        <p class="mt-6 text-neutral-400">there is no categories yet</p>
    @else
        <x-stacked-list class="mt-6">
            @foreach ($categories as $category)
                <x-stacked-list-item class="flex justify-between items-center">
                    <div>{{ $category->name }}</div>

                    <div class="inline-flex gap-2 items-center">
                        <a href={{ route('categories.edit', $category) }} class="text-sm">Edit</a>
                        <form method="post" action={{ route('categories.destroy', $category) }}>
                            @method('delete')
                            @csrf
                            <button class="text-sm">Delete</button>
                        </form>
                    </div>
                </x-stacked-list-item>
            @endforeach
        </x-stacked-list>
    @endif


</x-layouts.app>
