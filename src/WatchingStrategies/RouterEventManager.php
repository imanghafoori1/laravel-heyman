<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Illuminate\Support\Str;

class RouterEventManager extends BaseManager
{
    protected $type = 'route';
    
    private $matchedCallbacks = [];

    public function findMatchingCallbacks(array $matchedRoute): array
    {
        $this->matchedCallbacks = [];
        foreach (array_filter($matchedRoute) as $info) {
            $this->getMatched($info);
        }

        return $this->matchedCallbacks;
    }

    /**
     * @param $info
     */
    private function getMatched(string $info)
    {
        foreach ($this->data as $routeInfo => $callBacks) {
            if (Str::is($routeInfo, $info)) {
                $this->matchedCallbacks[] = $callBacks['default'];
            }
        }
    }
}
