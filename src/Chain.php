<?php

namespace Imanghafoori\HeyMan;

class Chain
{
    /**
     * @var \Imanghafoori\HeyMan\Chain
     */
    private $chainInfo = [];

    public function startChain()
    {
        $this->chainInfo = [];
    }

    public function get($key)
    {
        return $this->chainInfo[$key] ?? null;
    }

    public function set($key, $value)
    {
        $this->chainInfo[$key] = $value;
    }

    public function push($key, $value)
    {
        $this->chainInfo[$key][] = $value;
    }

    /**
     * ViewEventManager constructor.
     *
     * @param $manager
     * @param array  $values
     * @param string $param
     */
    public function init($manager, array $values, string $param = 'default')
    {
        $this->set('manager', $manager);
        $this->set('watchedEntities', $values);
        $this->set('event', $param);
    }
}
