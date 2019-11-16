<?php

namespace Imanghafoori\HeyMan\Plugins\Reactions;

use Imanghafoori\HeyMan\Reactions\Then;
use Imanghafoori\HeyMan\Core\BaseReaction;
use Illuminate\Http\Exceptions\HttpResponseException;

final class WeRespondFrom extends BaseReaction
{
    public function weRespondFrom($callback, array $parameters = [])
    {
        $this->commit(func_get_args(), [static::class, 'respondFrom']);

        return new Then($this);
    }

    public static function respondFrom($method)
    {
        return function ($meta = null) use ($method) {
            array_push($method, [$meta]);

            if (is_array($method[0])) {
                $response = call_user_func_array(...$method);
            } else {
                $response = app()->call(...$method);
            }

            throw new HttpResponseException($response);
        };
    }
}
