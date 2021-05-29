<?php

namespace Imanghafoori\HeyMan\Plugins\Reactions;

use Illuminate\Http\Exceptions\HttpResponseException;
use Imanghafoori\HeyMan\Core\BaseReaction;
use Imanghafoori\HeyMan\Reactions\Then;

final class WeRespondFrom extends BaseReaction
{
    public function weRespondFrom($callback, array $parameters = [])
    {
        $this->commit(func_get_args(), [static::class, 'respondFrom']);

        return new Then($this);
    }

    public static function respondFrom($method)
    {
        return function () use ($method) {
            if (is_array($method[0])) {
                $method[] = [];
                $response = call_user_func_array(...$method);
            } else {
                $response = app()->call(...$method);
            }

            throw new HttpResponseException($response);
        };
    }
}
