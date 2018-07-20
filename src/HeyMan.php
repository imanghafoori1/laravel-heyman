<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Hooks\EloquentHooks;
use Imanghafoori\HeyMan\Hooks\EventHooks;
use Imanghafoori\HeyMan\Hooks\RouteHooks;
use Imanghafoori\HeyMan\Hooks\ViewHooks;

class HeyMan
{
    use EloquentHooks, RouteHooks, ViewHooks, EventHooks;
    /**
     * @var \Imanghafoori\HeyMan\ListenerApplier
     */
    public $authorizer;

    /**
     * @param $url
     *
     * @return array
     */
    private function normalizeInput(array $url): array
    {
        return is_array($url[0]) ? $url[0] : $url;
    }

    /**
     * @param $value
     *
     * @return YouShouldHave
     */
    private function authorize($value): YouShouldHave
    {
        $this->authorizer = app(ListenerApplier::class)->init($value);

        return app(YouShouldHave::class);
    }

    public function startListening($response, $exception)
    {
        $callbackListener = app(ListenerFactory::class)->make($response, $exception);
        $this->authorizer->startGuarding($callbackListener);
    }
}
