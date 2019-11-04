<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\Plugins\Reactions\Nothing;

final class ResponderFactory
{
    public function make()
    {
        $chain = resolve('heyman.chain');
        $method = $chain->get('responseType') ?? [Nothing::class, 'nothing'];
        $data = $chain->get('data') ?? [];

        return call_user_func($method, ...$data);
    }
}
