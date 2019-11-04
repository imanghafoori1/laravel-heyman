<?php

namespace Imanghafoori\HeyMan\Plugins\Reactions;

use Illuminate\Http\Exceptions\HttpResponseException;
use Imanghafoori\HeyMan\Core\BaseReaction;
use Imanghafoori\HeyMan\Plugins\Reactions\Redirect\Redirector;
use Imanghafoori\HeyMan\Reactions\Responder;

class Response extends BaseReaction
{
    public function response()
    {
        resolve('heyman.chain')->set('responseType', [static::class, 'respond']);

        return new Responder($this);
    }

    public static function respond(...$resp)
    {
        return self::sendResponse($resp, 'response');
    }

    public function redirect()
    {
        resolve('heyman.chain')->set('responseType', [static::class, 'makeRedirect']);

        return new Redirector($this);
    }

    public static function makeRedirect(...$resp)
    {
        return self::sendResponse($resp, 'redirect');
    }

    private static function sendResponse(array $methodCalls, $func)
    {
        return function () use ($func, $methodCalls) {
            $respObj = $func();
            foreach ($methodCalls as $call) {
                [$method, $args] = $call;
                $respObj = $respObj->{$method}(...$args);
            }

            throw new HttpResponseException($respObj);
        };
    }
}
