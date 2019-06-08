<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Events;

final class EventSituations
{
    public $listener = EventListeners::class;

    public function hasMethod($method)
    {
        return in_array($method, [
            'whenEventHappens',
            'whenYouReachCheckPoint'
        ]);
    }

    public function __call($method, $name)
    {
        $args = $this->normalize($method, $name);
        resolve('heyman.chains')->init($this->listener, $args);
    }

    /**
     * @param $method
     * @param $name
     *
     * @return mixed
     */
    public function normalize($method, $name)
    {
        if ($method == 'whenYouReachCheckPoint') {
            $name[0] = 'heyman_checkpoint_'.$name[0];
        }

        return $name;
    }

    /**
     * @param mixed ...$event
     */
    /* public function whenEventHappens(...$event)
    {
        resolve('heyman.chains')->init(EventListeners::class, $event);
    }

    public function whenYouReachCheckPoint($name)
    {
        $this->whenEventHappens('heyman_checkpoint_'.$name);
    }*/
}
