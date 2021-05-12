<?php

namespace App\Services;

use Symfony\Component\Process\Process;
use App\Models\DockerImage;

class Container extends Process {

    public function __construct(
        DockerImage $img
    ) {
        parent::__construct(
            $this->getCommand($img),
            $img->app->fs_path,
            null,
            null,
            null
        );
    }

    private function getCommand(DockerImage $img): array {
        $cmd = [
            "docker",
            "run",
            "-it",
            "--name",
            sprintf("%s_%s", $img->app->slug, $img->slug)
        ];

        foreach($img->volumes as $path => $containerPath) {
            $cmd[] = "-v";
            $cmd[] = "$path:$containerPath";
        }

        return $cmd;
    }
}