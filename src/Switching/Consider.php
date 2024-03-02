<?php

namespace Imanghafoori\HeyMan\Switching;

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
    public static $methods = [
        'validationChecks' => 'validation',
    ];

    private $mode;

    public static function add($key, $listener)
    {
        self::$methods[$key] = $listener;
    }

    public function __construct($mode)
    {
        $this->mode = $mode;
    }

    public function __call($method, $args)
    {
        return $this->turn(self::$methods[$method], ...$args);
    }

    public function allChecks()
    {
        foreach (self::$methods as $method => $type) {
            $this->$method();
        }
    }

    /**
     * @param  $key
     * @param  callable|null  $closure
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
     * @param  $key
     */
    private function changeMode($key)
    {
        config()->set($key, [
            'turnOff' => true,
            'turnOn' => false,
        ][$this->mode]);
    }
}
