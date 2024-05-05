<?php

namespace BrianLogan\LaravelUserStatus\Traits;

trait HasStatus
{
    public bool $using_statuses = true;

    public function status()
    {
        if (config('user-status.keep_history')) {
            return $this->morphMany(config('user-status.status_model'), 'statusable');
        }

        return $this->morphOne(config('user-status.status_model'), 'statusable');
    }

    public function setStatus($status, $reason = null, $meta = null)
    {
        if (! config('user-status.keep_history')) {
            if ($this->status()->exists()) {
                $this->status()->update([
                    'status' => $status,
                    'reason' => $reason,
                    'meta' => $meta,
                ]);

                return;
            }
        }
        $this->status()->create([
            'status' => $status,
            'reason' => $reason,
            'meta' => $meta,
        ]);
    }

    public function getLatestStatus()
    {
        return $this->status()->latest()->first();
    }

    public function scopeWhereStatus($query, $status)
    {
        return $query->whereHas('status', function ($query) use ($status) {
            $query->where('name', $status);
        });
    }

    public function scopeWhereStatusReason($query, $reason)
    {
        return $query->whereHas('status', function ($query) use ($reason) {
            $query->where('reason', $reason);
        });
    }

    public function scopeWhereStatusMeta($query, $key, $value)
    {
        return $query->whereHas('status', function ($query) use ($key, $value) {
            $query->where('meta->'.$key, $value);
        });
    }
}
