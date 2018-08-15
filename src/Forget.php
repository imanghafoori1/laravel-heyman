<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\WatchingStrategies\EloquentEventsManager;
use Imanghafoori\HeyMan\WatchingStrategies\EventManager;
use Imanghafoori\HeyMan\WatchingStrategies\RouterEventManager;
use Imanghafoori\HeyMan\WatchingStrategies\ViewEventManager;

class Forget
{

    use ActionNormalizer;

    /**
     * Forget constructor.
     */
    public function __construct()
    {
    }

    public function aboutView(...$view)
    {
        resolve(ViewEventManager::class)->forgetAbout($this->normalizeInput($view));
    }

    public function aboutSaving(...$model)
    {
        $this->forgetForModel($model, 'saving');
    }

    public function aboutDeleting(...$model)
    {
        $this->forgetForModel($model, 'deleting');
    }

    public function aboutFetching(...$model)
    {
        $this->forgetForModel($model, 'retrieved');
    }

    public function aboutCreating(...$model)
    {
        $this->forgetForModel($model, 'creating');
    }

    public function aboutUpdating(...$model)
    {
        $this->forgetForModel($model, 'updating');
    }

    public function aboutModel(...$model)
    {
        resolve(EloquentEventsManager::class)->forgetAbout($this->normalizeInput($model));
    }

    public function aboutEvent(...$events)
    {
        resolve(EventManager::class)->forgetAbout($this->normalizeInput($events));
    }

    public function aboutUrl(...$urls)
    {
        resolve(RouterEventManager::class)->forgetAbout($this->normalizeUrl($urls, 'GET'));
    }

    public function aboutRoute(...$route)
    {
        resolve(RouterEventManager::class)->forgetAbout($this->normalizeInput($route));
    }

    public function aboutAction(...$actions)
    {
        $this->forgetAboutRoute($this->normalizeAction($actions));
    }

    /**
     * @param $model
     * @param $event
     */
    private function forgetForModel($model, $event)
    {
        resolve(EloquentEventsManager::class)->forgetAbout($this->normalizeInput($model), $event);
    }
}
