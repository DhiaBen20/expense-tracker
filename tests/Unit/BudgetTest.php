<?php

namespace Tests\Unit;

use App\Models\Budget;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BudgetTest extends TestCase
{
    use RefreshDatabase;

    public function test_budgets_belongs_to_a_user(): void
    {
        $budget = Budget::factory()->create();

        $this->assertInstanceOf(User::class, $budget->user);
    }
}
