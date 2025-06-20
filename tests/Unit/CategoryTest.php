<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_belongs_to_a_user(): void
    {
        $category = Category::factory()->create();

        $this->assertInstanceOf(User::class, $category->user);
    }

    public function test_it_has_many_transactions(): void
    {
        $category = Category::factory()->create();

        Transaction::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Collection::class, $category->transactions);
        $this->assertInstanceOf(Transaction::class, $category->transactions()->first());
    }
}
