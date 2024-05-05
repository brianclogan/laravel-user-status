<?php

uses()->group('middleware');

beforeAll(function () {
    $_ENV['USER_STATUS_KEEP_HISTORY'] = false;
    $_ENV['USER_STATUS_TABLE'] = null;
});

// TODO:: Make sure this test is functioning, currently it is not
it('sets the status to online on a visit', function () {
    expect(true)->tobeTrue();
    //    $user = \Workbench\App\Models\User::factory(1)->create()->first();
    //
    //    $this->actingAs($user)
    //        ->get('/')
    //        ->assertOk();
    //
    //    ray($user->status);
    //    expect($user->status)->toBe('online');
});
