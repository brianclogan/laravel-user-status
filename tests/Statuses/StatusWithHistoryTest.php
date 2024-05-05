<?php

use Workbench\App\Models\TestModel;

uses()->group('status');

beforeAll(function () {
    $_ENV['USER_STATUS_KEEP_HISTORY'] = true;
    $_ENV['USER_STATUS_TABLE'] = null;
});

describe('Status with history', function() {
    it('can create a status', function () {
        $model = TestModel::factory(1)->create()->first();
        $this->assertDatabaseHas('test_models', ['name' => $model->name]);

        $status = \Illuminate\Support\Str::random();

        $model->setStatus($status);
        $this->assertDatabaseHas(config('user-status.tables.status_table'), ['statusable_id' => $model->id, 'status' => $status]);
    });
    it('can have multiple statuses', function () {
        $model = TestModel::factory(1)->create()->first();
        $this->assertDatabaseHas('test_models', ['name' => $model->name]);

        $status1 = \Illuminate\Support\Str::random();
        $status2 = \Illuminate\Support\Str::random();

        $model->setStatus($status1);
        sleep(1); // This is to ensure that the timestamps are different, sqlite is too fast
        $model->setStatus($status2);

        $this->assertDatabaseHas(config('user-status.tables.status_table'), ['statusable_id' => $model->id, 'status' => $status1]);
        $this->assertDatabaseHas(config('user-status.tables.status_table'), ['statusable_id' => $model->id, 'status' => $status2]);

        $latest = $model->getLatestStatus();
        $this->assertEquals($status2, $latest->status);
    });
});
