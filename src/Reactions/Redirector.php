<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\Chain;

/**
 * Class Redirector.
 *
 * @method RedirectMsg to(string $path, int $status = 302, array $headers = [], $secure = null)
 * @method RedirectMsg route(string $route, array $parameters = [], int $status = 302, array $headers = [])
 * @method RedirectMsg action($action, array $parameters = [], int $status = 302, array $headers = [])
 * @method RedirectMsg guest($path, int $status = 302, array $headers = [], $secure = null)
 * @method RedirectMsg intended(string $default = '/', int $status = 302, array $headers = [], $secure = null)
 */
class Redirector
{
    private $action;

    /**
     * Responder constructor.
     *
     * @param Reactions $reaction
     */
    public function __construct(Reactions $reaction)
    {
        $this->action = $reaction;
    }

    public function __call($method, $parameters)
    {
        resolve(Chain::class)->commitCalledMethod([$method, $parameters], 'redirect');

        return new RedirectionMsg($this);
    }
}
