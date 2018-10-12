<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Normilizers\InputNormalizer;
use Imanghafoori\HeyMan\WatchingStrategies\EloquentModels\EloquentEventsManager;
use Imanghafoori\HeyMan\WatchingStrategies\Events\EventManager;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouteNormalizer;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouterEventManager;
use Imanghafoori\HeyMan\WatchingStrategies\Views\ViewEventManager;

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
