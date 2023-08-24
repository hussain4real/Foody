<?php

test('foods page is displayed', function () {
    $foods = \App\Models\Food::factory()->count(10)->create();
    $this->assertCount(10, $foods);

    $response = $this->get('/foods');

    $response->assertOk();
});

test('foods page is displayed with the user that posted the food', function () {
    $user = \App\Models\User::factory()->create();
    $food = \App\Models\Food::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->get('/foods');

    $response->assertOk();
    $response->assertSee($user->first_name);
});
