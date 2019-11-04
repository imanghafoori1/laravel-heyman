<?php

namespace Imanghafoori\HeyMan\Core;

/**
 * Class Forget.
 *
 * @method aboutRoute(array|string $routeName)
 * @method aboutAction(array|string $action)
 * @method aboutUrl(array|string $url)
 * @method aboutModel(array|string $model)
 * @method aboutDeleting(array|string $model)
 * @method aboutSaving(array|string $model)
 * @method aboutCreating(array|string $model)
 * @method aboutUpdating(array|string $model)
 * @method aboutFetching(array|string $model)
 */
final class Forget
{
    public static $situationProviders;

    public function __call($method, $args)
    {
        $args = is_array($args[0]) ? $args[0] : $args;

        foreach (static::$situationProviders as $class) {
            if (in_array($method, $class::getForgetMethods())) {
                $args = $class::getForgetArgs($method, $args);
            }
        }

        resolve('heyman.chains')->forgetAbout(...$args);
    }
}
