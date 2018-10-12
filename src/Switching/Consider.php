<?php

namespace Imanghafoori\HeyMan\Switching;

use Imanghafoori\HeyMan\WatchingStrategies\EloquentModels\EloquentEventsManager;
use Imanghafoori\HeyMan\WatchingStrategies\Events\EventManager;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouterEventManager;
use Imanghafoori\HeyMan\WatchingStrategies\Views\ViewEventManager;

/**
 * Class Consider.
 *
 * @method null eventChecks(null|callable $closure = null)
 * @method null viewChecks(null|callable $closure = null)
 * @method null routeChecks(null|callable $closure = null)
 * @method null eloquentChecks(null|callable $closure = null)
 * @method null validationChecks(null|callable $closure = null)
 */
class Consider
{
    private $mode;

    public function __construct($mode)
    {
        $this->mode = $mode;
    }

    public function __call($method, $args)
    {
        $m = $this->methods();

        return $this->turn($m[$method], ...$args);
    }

    public function allChecks()
    {
        foreach ($this->methods() as $method => $type) {
            $this->$method();
        }
    }

    /**
     * @param $key
     * @param callable|null $closure
     */
    private function turn($key, callable $closure = null)
    {
        $key = 'heyman_ignore_'.$key;

        $current = config($key);
        $this->changeMode($key);

        if (is_null($closure)) {
            return;
        }
        $result = $closure();
        config()->set($key, $current);

        return $result;
    }

    /**
     * @param $key
     */
    private function changeMode($key)
    {
        config()->set($key, [
            'turnOff' => true,
            'turnOn'  => false,
        ][$this->mode]);
    }

    /**
     * @return array
     */
    private function methods(): array
    {
        return [
            'eventChecks'      => EventManager::class,
            'viewChecks'       => ViewEventManager::class,
            'routeChecks'      => RouterEventManager::class,
            'eloquentChecks'   => EloquentEventsManager::class,
            'validationChecks' => 'validation',
        ];
    }
}
