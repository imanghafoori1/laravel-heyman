<?php

namespace Imanghafoori\HeyMan\Reactions;

/**
 * Class Responder.
 *
 * @method Then make(string $content = '', int $status = 200, array $headers = [])
 * @method Then view(string $view, array $data = [], int $status = 200, array $headers = [])
 * @method Then json($data = [], $status = 200, array $headers = [], $options = 0)
 * @method Then jsonp($callback, $data = [], $status = 200, array $headers = [], $options = 0)
 * @method Then stream($callback, $status = 200, array $headers = [])
 * @method Then streamDownload($callback, $name = null, array $headers = [], $disposition = 'attachment')
 * @method Then download($file, $name = null, array $headers = [], $disposition = 'attachment')
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

        return new Then($this->action);
    }
}
