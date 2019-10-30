<?php

namespace Imanghafoori\HeyMan\Core;

use Imanghafoori\HeyMan\HeyManServiceProvider;
use Imanghafoori\HeyMan\Normilizers\InputNormalizer;

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
    use InputNormalizer;

    public static $situation_providers;

    public function __call($method, $args)
    {
        $args = $this->normalizeInput($args);

        foreach (static::$situation_providers as $class) {
            if (in_array($method, $class::getForgetMethods())) {
                $args = $class::getForgetArgs($method, $args);
            }
        }

        resolve('heyman.chains')->forgetAbout(...$args);
    }
}
