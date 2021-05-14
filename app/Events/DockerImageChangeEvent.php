<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\Channel;
use App\Models\DockerImage;

class DockerImageChangeEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public DockerImage $dockerImage;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DockerImage $dockerImage)
    {
        $this->dockerImage = $dockerImage;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('docker-image-change');
    }
}
