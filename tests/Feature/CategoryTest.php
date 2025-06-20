<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_users_can_create_categories(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->assertDatabaseEmpty(Category::class);

        $this->post(route('categories.store'), ['name' => 'Food'])
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas(Category::class, [
            'user_id' => $user->id,
            'name' => 'Food',
        ]);
    }

    public function test_creating_categories_requires_valid_data(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('categories.store'))
            ->assertSessionHasErrors(['name']);
    }

    public function test_user_can_see_list_of_categories(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $category = Category::factory()->for($user)->create();

        $category2 = Category::factory()->create();

        $this->get(route('categories.index'))
            ->assertOk()
            ->assertSee($category->name)
            ->assertDontSee($category2->name);
    }
}
