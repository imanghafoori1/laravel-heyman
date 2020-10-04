<?php

namespace Imanghafoori\HeyMan\Contracts;

interface ForgettableSituation
{
    public function getListener();

    public function getSituationProvider();

    public function getMethods();

    public function getForgetKey();

    public static function getForgetMethods();

    public static function getForgetArgs($method, $args);
}
