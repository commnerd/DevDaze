<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ContainerChangeEvent;

class BumpServiceListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ContainerChangeEvent  $event
     * @return void
     */
    public function handle(ContainerChangeEvent $event)
    {
        $event->container->run();

        if(!$event->container->isSuccessful()) {
            dd($event->container->getErrorOutput());
        }

        dd($event->container->getOutput());
    }
}
