<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_belongs_to_a_user()
    {
        $transaction = Transaction::factory()->create();

        $this->assertInstanceOf(User::class, $transaction->user);
    }

    public function test_it_belongs_to_a_category()
    {
        $transaction = Transaction::factory()->create();

        $this->assertInstanceOf(Category::class, $transaction->category);
    }
}
