<?php

namespace Imanghafoori\HeyMan\Plugins\Reactions\Redirect;

use Imanghafoori\HeyMan\Reactions\PreReactions;

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
     * @param PreReactions $reaction
     */
    public function __construct($reaction)
    {
        $this->action = $reaction;
    }

    public function __call($method, $parameters)
    {
        resolve('heyman.chain')->push('data', [$method, $parameters]);

        return new RedirectionMsg($this);
    }
}
