<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_users_can_create_transactions(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $transaction = Transaction::factory()->for($user)->raw();

        $this->assertDatabaseEmpty(Transaction::class);

        $this->post(route('transactions.store'), $transaction)
            ->assertRedirect(route('transactions.index'));

        $this->assertDatabaseHas(Transaction::class, $transaction);
    }

    public function test_creating_transactions_requires_valid_data(): void 
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('transactions.store'))
            ->assertSessionHasErrors(["description", "amount", "date", "category_id"]);

        $this->post(route('transactions.store'), ["category_id" => 55555])
            ->assertSessionHasErrors("category_id");
    }

    public function test_user_can_see_list_of_transactions(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $transactions = Transaction::factory(2)->for($user)->create();
        $anotherTransaction = Transaction::factory()->create();

        $this->get(route('transactions.index'))
            ->assertOk()
            ->assertSee($transactions[0]->name)
            ->assertSee($transactions[1]->name)
            ->assertDontSee($anotherTransaction->name);
    }
}
