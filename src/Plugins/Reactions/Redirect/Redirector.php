<?php

namespace Imanghafoori\HeyMan\Plugins\Reactions\Redirect;

/**
 * Class Redirector.
 *
 * @method RedirectionMsg to(string $path, int $status = 302, array $headers = [], $secure = null)
 * @method RedirectionMsg route(string $route, array $parameters = [], int $status = 302, array $headers = [])
 * @method RedirectionMsg action($action, array $parameters = [], int $status = 302, array $headers = [])
 * @method RedirectionMsg guest($path, int $status = 302, array $headers = [], $secure = null)
 * @method RedirectionMsg intended(string $default = '/', int $status = 302, array $headers = [], $secure = null)
 */
class Redirector
{
    private $action;

    /**
     * Responder constructor.
     *
     * @param  \Imanghafoori\HeyMan\Plugins\PreReaction\PreReactions  $reaction
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
