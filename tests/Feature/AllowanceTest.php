<?php

use Database\Factories\UserFactory;
use Database\Factories\AllowanceFactory;
use Database\Factories\ExpenseFactory;

test('allowance page is displayed', function () {
    $user = UserFactory::new()->create();

    $response = $this
        ->actingAs($user)
        ->get('/allowance');

    $response->assertOk();
});

test('allowance information can be created', function () {
    $user = UserFactory::new()->create();
    $allowance = AllowanceFactory::new()->create(['user_id' => $user->id]);

    $response = $this
        ->actingAs($user)
        ->patch('/allowance/create', [
            'user_id' => 2,
            'allowance' => '1000',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/allowance');

    $allowance->refresh();
    $this->assertSame('1000', $allowance->allowance);
});

test('allowance information can be updated', function () {
    $user = UserFactory::new()->create();
    $allowance = AllowanceFactory::new()->create(['user_id' => $user->id]);

    $response = $this
        ->actingAs($user)
        ->patch('/allowance/edit', [
            'user_id' => 2,
            'allowance' => '1000',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/allowance');

    $allowance->refresh();
    $this->assertSame('1000', $allowance->allowance);
});

test('user can delete their allowance', function () {
    $user = UserFactory::new()->create();
    $allowance = AllowanceFactory::new()->create(['user_id' => $user->id]);

    $response = $this
        ->actingAs($user)
        ->delete('/allowance');

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/allowance');

    $this->assertNull($allowance->fresh());
});

test('allowance page displays weekly expenses summary', function () {
    $user = UserFactory::new()->create();

    ExpenseFactory::new()->create(['user_id' => $user->id, 'type' => '1', 'expense' => 100, 'created_at' => now()->startOfWeek()]);
    ExpenseFactory::new()->create(['user_id' => $user->id, 'type' => '2', 'expense' => 200, 'created_at' => now()->startOfWeek()->addDay(1)]);

    $response = $this
        ->actingAs($user)
        ->get('/allowance');

    $response->assertOk();

    $weeklyExpenses = $response->viewData('page')['props']['weeklyExpenses'];

    $this->assertCount(2, $weeklyExpenses);
    $this->assertContains(['type' => '1', 'total' => 100.0], $weeklyExpenses);
    $this->assertContains(['type' => '2', 'total' => 200.0], $weeklyExpenses);
});