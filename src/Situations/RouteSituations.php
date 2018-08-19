<?php

namespace Imanghafoori\HeyMan\Situations;

use Imanghafoori\HeyMan\Chain;
use Imanghafoori\HeyMan\Normilizers\InputNormalizer;
use Imanghafoori\HeyMan\Normilizers\RouteNormalizer;
use Imanghafoori\HeyMan\WatchingStrategies\RouterEventManager;
use Imanghafoori\HeyMan\YouShouldHave;

class RouteSituations
{
    private $chain;

    use InputNormalizer;

    use RouteNormalizer;

    /**
     * HeyMan constructor.
     *
     * @param Chain $chain
     */
    public function __construct(Chain $chain)
    {
        $this->chain = $chain;
    }


    /**
     * @param mixed ...$url
     *
     * @return YouShouldHave
     */
    public function whenYouVisitUrl(...$url): YouShouldHave
    {
        return $this->watchURL($url, 'GET');
    }

    /**
     * @param mixed ...$url
     *
     * @return YouShouldHave
     */
    public function whenYouSendPost(...$url): YouShouldHave
    {
        return $this->watchURL($url, 'POST');
    }

    /**
     * @param mixed ...$url
     *
     * @return YouShouldHave
     */
    public function whenYouSendPatch(...$url): YouShouldHave
    {
        return $this->watchURL($url, 'PATCH');
    }

    /**
     * @param mixed ...$url
     *
     * @return YouShouldHave
     */
    public function whenYouSendPut(...$url): YouShouldHave
    {
        return $this->watchURL($url, 'PUT');
    }

    /**
     * @param mixed ...$url
     *
     * @return YouShouldHave
     */
    public function whenYouSendDelete(...$url): YouShouldHave
    {
        return $this->watchURL($url, 'DELETE');
    }

    /**
     * @param mixed ...$routeName
     *
     * @return YouShouldHave
     */
    public function whenYouHitRouteName(...$routeName): YouShouldHave
    {
        return $this->watchRoute($this->normalizeInput($routeName));
    }

    /**
     * @deprecated
     *
     * @param mixed ...$routeName
     *
     * @return YouShouldHave
     */
    public function whenYouReachRoute(...$routeName): YouShouldHave
    {
        return $this->whenYouHitRouteName(...$routeName);
    }

    /**
     * @param mixed ...$action
     *
     * @return YouShouldHave
     */
    public function whenYouCallAction(...$action): YouShouldHave
    {
        return $this->watchRoute($this->normalizeAction($action));
    }

    /**
     * @param $value
     *
     * @return YouShouldHave
     */
    private function watchRoute($value): YouShouldHave
    {
        $this->chain->eventManager = app(RouterEventManager::class)->init($value);

        return app(YouShouldHave::class);
    }

    /**
     * @param $url
     * @param $verb
     *
     * @return YouShouldHave
     */
    private function watchURL($url, $verb): YouShouldHave
    {
        return $this->watchRoute($this->normalizeUrl($url, $verb));
    }
}