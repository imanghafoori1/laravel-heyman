<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\WatchingStrategies\EventManager;
use Imanghafoori\HeyMan\WatchingStrategies\RouterEventManager;
use Imanghafoori\HeyMan\WatchingStrategies\ViewEventManager;

class Forget
{
    /**
     * @param $url
     *
     * @return array
     */
    private function normalizeInput(array $url): array
    {
        return is_array($url[0]) ? $url[0] : $url;
    }

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

    public function aboutSaving()
    {
    }

    public function aboutDeleting()
    {
    }

    public function aboutCreating()
    {
    }

    public function aboutUpdating()
    {
    }

    public function aboutModel()
    {
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
        resolve(RouterEventManager::class)->forgetAbout($this->normalizeAction($actions));
    }

    /**
     * @param $url
     * @param $verb
     *
     * @return array
     */
    private function normalizeUrl($url, $verb): array
    {
        $removeSlash = function ($url) use ($verb) {
            return $verb.ltrim($url, '/');
        };

        return array_map($removeSlash, $this->normalizeInput($url));
    }

    /**
     * @param $action
     *
     * @return array
     */
    private function normalizeAction($action): array
    {
        $addNamespace = function ($action) {
            if ($action = ltrim($action, '\\')) {
                return $action;
            }

            return app()->getNamespace().'\\Http\\Controllers\\'.$action;
        };

        $action = array_map($addNamespace, $this->normalizeInput($action));

        return $action;
    }
}
