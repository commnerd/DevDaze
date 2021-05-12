<?php

namespace App\Traits;

use App\Events\ContainerSaved;

trait BumpsService {
    public function save() {
        parent::save();

        ContainerSaved::dispatch($container);
    }
}