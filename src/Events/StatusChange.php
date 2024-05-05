<?php

namespace BrianLogan\LaravelUserStatus\Events;

use BrianLogan\LaravelUserStatus\Models\Status;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class StatusChange
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Status $status,
    ) {
    }

    public function broadcastOn()
    {
        if (config('user-status.echo.enabled')) {
            $channel = config('user-status.echo.channel');
            if (Str::contains('{id}', config('user-status.echo.channel'))) {
                Str::replace('{id}', $this->status->statusable->id, $channel);
            }
            if (Str::contains('{type}', config('user-status.echo.channel'))) {
                Str::replace('{type}', $this->status->statusable->getMorphClass(), $channel);
            }

            return new Channel($channel);
        }

        return false;
    }

    public function broadcastWith()
    {
        return [
            'status' => $this->status->status,
        ];
    }
}
