<?php

namespace Imanghafoori\HeyMan\Reactions;

/**
 * Class Responder.
 *
 * @method null make(string $content = '', int $status = 200, array $headers = [])
 * @method null view(string $view, array $data = [], int $status = 200, array $headers = [])
 * @method null json($data = [], $status = 200, array $headers = [], $options = 0)
 * @method null jsonp($callback, $data = [], $status = 200, array $headers = [], $options = 0)
 * @method null stream($callback, $status = 200, array $headers = [])
 * @method null streamDownload($callback, $name = null, array $headers = [], $disposition = 'attachment')
 * @method null download($file, $name = null, array $headers = [], $disposition = 'attachment')
 */
final class Responder
{
    private $action;

    /**
     * Responder constructor.
     *
     * @param $action
     */
    public function __construct(Reactions $action)
    {
        $this->action = $action;
    }

    public function __call($method, $parameters)
    {
        resolve('heyman.chain')->push('data', [$method, $parameters]);
    }
}
