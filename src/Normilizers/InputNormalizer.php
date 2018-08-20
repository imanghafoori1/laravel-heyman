<?php

namespace Imanghafoori\HeyMan\Normilizers;

trait InputNormalizer
{
    /**
     * @param $url
     *
     * @return array
     */
    protected function normalizeInput(array $url): array
    {
        return is_array($url[0]) ? $url[0] : $url;
    }
}
