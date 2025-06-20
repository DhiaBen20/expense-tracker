<?php

namespace Tests\Unit;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase as Tests;

class UserTest extends Tests
{
    use RefreshDatabase;

    public function test_users_has_many_categories(): void
    {
        $user = User::factory()->create();

        Category::factory(2)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Category::class, $user->categories->first());
        $this->assertInstanceOf(Collection::class, $user->categories);
        $this->assertEquals(2, count($user->categories));
    }

    public function test_users_has_many_transactions(): void
    {
        $user = User::factory()->create();

        Transaction::factory(2)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Transaction::class, $user->transactions->first());
        $this->assertInstanceOf(Collection::class, $user->transactions);
        $this->assertEquals(2, $user->transactions->count());
    }

    public function test_users_has_many_budgets(): void
    {
        $user = User::factory()->create();

        Budget::factory(2)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Budget::class, $user->budgets->first());
        $this->assertInstanceOf(Collection::class, $user->budgets);
        $this->assertEquals(2, $user->budgets->count());
    }
}
