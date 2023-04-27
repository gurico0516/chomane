<?php

use App\Models\User;
use App\Models\Allowance;

test('allowance page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/allowance');

    $response->assertOk();
});

test('allowance information can be updated', function () {
    $allowance = Allowance::factory()->create();

    $response = $this
        ->actingAs($allowance)
        ->patch('/allowance', [
            'allowance' => '100',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/allowance');

        $allowance->refresh();

        $this->assertSame('100', $allowance->allowance);
});
