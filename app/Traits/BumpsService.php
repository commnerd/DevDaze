<?php

namespace App\Traits;

use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Interfaces\DockerImageDescendant;
use App\Jobs\BumpService;

trait BumpsService {
    use DispatchesJobs;

    public function save(array $options = []) {
        parent::save($options);

        $this->dispatch(new BumpService($this->docker_image));
    }
}
