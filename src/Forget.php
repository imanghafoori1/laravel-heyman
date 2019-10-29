<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Normilizers\InputNormalizer;
use Imanghafoori\HeyMan\WatchingStrategies\EloquentModels\EloquentSituationProvider;
use Imanghafoori\HeyMan\WatchingStrategies\Events\EventListeners;
use Imanghafoori\HeyMan\WatchingStrategies\Events\EventSituationProvider;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouteActionNormalizer;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouteActionProvider;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouteNameNormalizer;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouteNameSituationProvider;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouteNormalizer;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouteUrlSituationProvider;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouteUrlsNormalizer;
use Imanghafoori\HeyMan\WatchingStrategies\Views\ViewEventListener;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouteEventListener;
use Imanghafoori\HeyMan\WatchingStrategies\EloquentModels\EloquentEventsListener;
use Imanghafoori\HeyMan\WatchingStrategies\Views\ViewSituationProvider;

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

    public function __call($method, $args)
    {
        $args = $this->normalizeInput($args);

        foreach (HeyManServiceProvider::$situationProviders as $class) {
            if (in_array($method, $class::getForgetMethods())) {
                $args = $class::getForgetArgs($method, $args);
            }
        }

        resolve('heyman.chains')->forgetAbout(...$args);
    }
}
