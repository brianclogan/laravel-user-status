<?php

use Workbench\App\Models\TestModel;

uses()->group('custom-tables');

beforeAll(function () {
    $_ENV['USER_STATUS_TABLE'] = 'custom_status_table';
});

it('can create custom status table', function () {
    $model = TestModel::factory(1)->create()->first();
    $this->assertDatabaseHas('test_models', ['name' => $model->name]);

    $status = \Illuminate\Support\Str::random();

    $model->setStatus($status);
    $this->assertDatabaseHas('custom_status_table', ['statusable_id' => $model->id, 'status' => $status]);
});
