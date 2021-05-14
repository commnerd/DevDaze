<?php

namespace App\Interfaces;

use App\Models\DockerImage;

interface DockerImageDescendant {
    public function getDockerImage(): DockerImage;
}