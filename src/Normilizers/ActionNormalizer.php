<?php

namespace Imanghafoori\HeyMan\Normilizers;

trait ActionNormalizer
{
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

        return array_map($addNamespace, $this->normalizeInput($action));
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
}
