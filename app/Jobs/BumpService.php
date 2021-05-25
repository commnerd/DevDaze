<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use App\Models\Image;
use App\Services\Docker;

class BumpService implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Image $dockerImage;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Image $dockerImage)
    {
        $this->dockerImage = $dockerImage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Docker::restart($this->dockerImage);
    }
}
