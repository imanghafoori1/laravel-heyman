<?php

namespace Imanghafoori\HeyMan;

class StartGuarding
{
    public function start()
    {
        $chains = resolve('heyman.chains')->data;

        foreach ($chains as $manager => $data) {
            resolve($manager)->startWatching($data);
        }

        // We free up the memory here ...
        // Although it is a very small amount
        resolve('heyman.chains')->data = [];
    }
}
