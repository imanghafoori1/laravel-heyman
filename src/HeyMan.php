<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Hooks\EloquentHooks;

class HeyMan
{
    use EloquentHooks;
    /**
     * @var \Imanghafoori\HeyMan\ConditionApplier
     */
    public $authorizer;

    public function whenVisitingUrl(...$url)
    {
        return $this->authorizeRoute('urls', $url);
    }

    public function whenVisitingRoute(...$routeName)
    {
        return $this->authorizeRoute('routeNames', $routeName);
    }

    public function whenCallingAction(...$action)
    {
        return $this->authorizeRoute('actions', $action);
    }

    public function whenYouSeeViewFile(...$view)
    {
        $view = $this->normalizeView($view);
        return $this->authorize($view);
    }

    public function whenEventHappens(...$event)
    {
        return $this->authorize($this->normalizeInput($event));
    }

    /**
     * @param $url
     * @return array
     */
    private function normalizeInput(array $url): array
    {
        return is_array($url[0]) ? $url[0] : $url;
    }

    /**
     * @param $value
     */
    private function authorize($value): YouShouldHave
    {
        $this->authorizer = app('hey_man_authorizer')->init($value);
        return app('hey_man_you_should_have');
    }

    private function authorizeRoute($target, $value)
    {
        $this->authorizer = app('hey_man_route_authorizer')->init($target, $this->normalizeInput($value));
        return app('hey_man_you_should_have');
    }

    /**
     * @param $views
     * @return array
     */
    private function normalizeView(array $views): array
    {
        $views = $this->normalizeInput($views);
        $mapper = function ($view) {
            return 'creating: '.$view;
        };

        return array_map($mapper, $views);
    }
}