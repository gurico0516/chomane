<?php

use App\Models\Allowance;
use App\Models\User;

test('allowance page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/allowance');

    $response->assertOk();
});

test('allowance information can be created', function () {
    $user = User::factory()->create();
    $allowance = Allowance::factory()->create(['user_id' => $user->id]);

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
    $user = User::factory()->create();
    $allowance = Allowance::factory()->create(['user_id' => $user->id]);

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
    $user = User::factory()->create();
    $allowance = Allowance::factory()->create(['user_id' => $user->id]);

    $response = $this
        ->actingAs($user)
        ->delete('/allowance');

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/allowance');

    $this->assertNull($allowance->fresh());
});
