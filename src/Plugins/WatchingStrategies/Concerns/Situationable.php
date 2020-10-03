<?php

namespace Imanghafoori\HeyMan\Plugins\WatchingStrategies\Concerns;

interface Situationable {
    public function getListener();
    public function getSituationProvider();
    public function getMethods();
    public function getForgetKey();
    public static function getForgetMethods();
    public static function getForgetArgs($method, $args);
}