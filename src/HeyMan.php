<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Hooks\EloquentHooks;
use Imanghafoori\HeyMan\Hooks\RouteHooks;

class HeyMan
{
    use EloquentHooks, RouteHooks;
    /**
     * @var \Imanghafoori\HeyMan\ConditionApplier
     */
    public $authorizer;

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