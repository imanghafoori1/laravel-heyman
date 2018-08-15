<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Normilizers\ActionNormalizer;
use Imanghafoori\HeyMan\Normilizers\InputNormalizer;
use Imanghafoori\HeyMan\WatchingStrategies\EloquentEventsManager;
use Imanghafoori\HeyMan\WatchingStrategies\EventManager;
use Imanghafoori\HeyMan\WatchingStrategies\RouterEventManager;
use Imanghafoori\HeyMan\WatchingStrategies\ViewEventManager;

class Forget
{
    use ActionNormalizer, InputNormalizer;

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
        $this->forgetAboutModel($model, 'saving');
    }

    public function aboutDeleting(...$model)
    {
        $this->forgetAboutModel($model, 'deleting');
    }

    public function aboutFetching(...$model)
    {
        $this->forgetAboutModel($model, 'retrieved');
    }

    public function aboutCreating(...$model)
    {
        $this->forgetAboutModel($model, 'creating');
    }

    public function aboutUpdating(...$model)
    {
        $this->forgetAboutModel($model, 'updating');
    }

    public function aboutModel(...$model)
    {
        resolve(EloquentEventsManager::class)->forgetAbout($this->normalizeInput($model), null);
    }

    public function aboutEvent(...$events)
    {
        resolve(EventManager::class)->forgetAbout($this->normalizeInput($events));
    }

    public function aboutUrl(...$urls)
    {
        $this->forgetAboutRoute($this->normalizeUrl($urls, 'GET'));
    }

    public function aboutRoute(...$route)
    {
        $this->forgetAboutRoute($this->normalizeInput($route));
    }

    public function aboutAction(...$actions)
    {
        $this->forgetAboutRoute($this->normalizeAction($actions));
    }

    /**
     * @param $model
     * @param $event
     */
    private function forgetAboutModel($model, $event)
    {
        resolve(EloquentEventsManager::class)->forgetAbout($this->normalizeInput($model), $event);
    }

    /**
     * @param $normalizeUrl
     */
    private function forgetAboutRoute($normalizeUrl)
    {
        resolve(RouterEventManager::class)->forgetAbout($normalizeUrl);
    }
}
