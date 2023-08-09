<?php

use Database\Factories\UserFactory;
use Database\Factories\AllowanceFactory;

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
