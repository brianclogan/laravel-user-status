<?php

namespace BrianLogan\LaravelUserStatus\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $casts = [
        'meta' => 'json',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('user-status.tables.status_table');
    }

    public function statusable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function scopeForModel($query, $model)
    {
        return $query->where('model_type', get_class($model))
            ->where('model_id', $model->id);
    }

    public function scopeForStatus($query, $status)
    {
        return $query->where('name', $status);
    }

    public function scopeForReason($query, $reason)
    {
        return $query->where('reason', $reason);
    }
}
