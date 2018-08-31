<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Normilizers\InputNormalizer;
use Imanghafoori\HeyMan\Normilizers\RouteNormalizer;
use Imanghafoori\HeyMan\WatchingStrategies\EloquentEventsManager;
use Imanghafoori\HeyMan\WatchingStrategies\EventManager;
use Imanghafoori\HeyMan\WatchingStrategies\RouterEventManager;
use Imanghafoori\HeyMan\WatchingStrategies\ViewEventManager;

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
class Forget
{
    use InputNormalizer;

    public function aboutView(...$view)
    {
        resolve(ViewEventManager::class)->forgetAbout($view);
    }

    public function aboutEvent(...$events)
    {
        resolve(EventManager::class)->forgetAbout($events);
    }

    public function __call($method, $args)
    {
        $args = $this->normalizeInput($args);

        $method = ltrim($method, 'about');

        if (in_array($method, ['Route', 'Action', 'Url'])) {
            $args = resolve(RouteNormalizer::class)->{'normalize'.$method}($args);

            return resolve(RouterEventManager::class)->forgetAbout($args);
        }

        $method = str_replace('Fetching', 'retrieved', $method);
        $method = strtolower($method);
        $method = $method == 'model' ? null : $method;
        resolve(EloquentEventsManager::class)->forgetAbout($args, $method);
    }
}
