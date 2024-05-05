<?php

use Workbench\App\Models\TestModel;

uses()->group('status');

beforeAll(function () {
    $_ENV['USER_STATUS_KEEP_HISTORY'] = false;
    $_ENV['USER_STATUS_TABLE'] = null;
});

describe('Status without history', function () {
    it('can create a status', function () {
        $model = TestModel::factory(1)->create()->first();
        $this->assertDatabaseHas('test_models', ['name' => $model->name]);

        $status = \Illuminate\Support\Str::random();

        $model->setStatus($status);
        $this->assertDatabaseHas(config('user-status.tables.status_table'), ['statusable_id' => $model->id, 'status' => $status]);
    });
    it('can not create multiple statuses', function () {
        $model = TestModel::factory(1)->create()->first();
        $this->assertDatabaseHas('test_models', ['name' => $model->name]);

        $status1 = \Illuminate\Support\Str::random();
        $status2 = \Illuminate\Support\Str::random();

        $model->setStatus($status1);
        sleep(1); // This is to ensure that the timestamps are different, sqlite is too fast
        $model->setStatus($status2);

        $this->assertDatabaseMissing(config('user-status.tables.status_table'), ['statusable_id' => $model->id, 'status' => $status1]);
        $this->assertDatabaseHas(config('user-status.tables.status_table'), ['statusable_id' => $model->id, 'status' => $status2]);

        $latest = $model->getLatestStatus();
        $this->assertEquals($status2, $latest->status);
    });
    it('can get the latest status', function () {
        $model = TestModel::factory(1)->create()->first();
        $this->assertDatabaseHas('test_models', ['name' => $model->name]);

        $status = \Illuminate\Support\Str::random();

        $model->setStatus($status);
        $this->assertDatabaseHas(config('user-status.tables.status_table'), ['statusable_id' => $model->id, 'status' => $status]);

        $latest = $model->getLatestStatus();
        $this->assertEquals($status, $latest->status);
    });
    it('can get the latest status with reason', function () {
        $model = TestModel::factory(1)->create()->first();
        $this->assertDatabaseHas('test_models', ['name' => $model->name]);

        $status = \Illuminate\Support\Str::random();
        $reason = \Illuminate\Support\Str::random();

        $model->setStatus($status, $reason);
        $this->assertDatabaseHas(config('user-status.tables.status_table'), ['statusable_id' => $model->id, 'status' => $status, 'reason' => $reason]);

        $latest = $model->getLatestStatus();
        $this->assertEquals($status, $latest->status);
        $this->assertEquals($reason, $latest->reason);
    });
    it('can get the latest status with meta', function () {
        $model = TestModel::factory(1)->create()->first();
        $this->assertDatabaseHas('test_models', ['name' => $model->name]);

        $status = \Illuminate\Support\Str::random();
        $reason = \Illuminate\Support\Str::random();
        $meta = ['foo' => 'bar'];

        $model->setStatus($status, $reason, $meta);
        $this->assertDatabaseHas(config('user-status.tables.status_table'), ['statusable_id' => $model->id, 'status' => $status, 'reason' => $reason, 'meta' => json_encode($meta)]);

        $latest = $model->getLatestStatus();
        $this->assertEquals($status, $latest->status);
        $this->assertEquals($reason, $latest->reason);
        $this->assertEquals($meta, $latest->meta);
    });
});
