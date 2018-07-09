<?php

namespace Imanghafoori\HeyMan;

class HeyMan
{
    private $urls = [];

    private $target;

    private $value;

    private $routeNames = [];

    public function whenVisitingUrl($url)
    {
        $this->value = $url;
        $this->target = 'urls';

        return $this;
    }

    public function whenVisitingRoute($routeName)
    {
        $this->value = $routeName;
        $this->target = 'routeNames';
        return $this;
    }

    public function getUrls()
    {
        return $this->urls;
    }

    public function youShouldHaveRole($role)
    {
        $this->{$this->target}[$this->value]['role'] = $role;
        return $this;
    }

    public function beCareful()
    {

    }

    public function getRouteNames()
    {
        return $this->routeNames;
    }

}