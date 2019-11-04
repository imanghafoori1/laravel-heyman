<?php

namespace Imanghafoori\HeyMan\Core;

class BaseReaction
{
    public function __destruct()
    {
        resolve('heyman.chains')->commitChain();
    }

    protected function commit($args, $methodName)
    {
        $chain = resolve('heyman.chain');
        $chain->push('data', $args);
        $chain->set('responseType', $methodName);
    }
}
