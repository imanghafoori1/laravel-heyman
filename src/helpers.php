<?php

if (! function_exists('resolve')) {
    /**
     * Resolve a service from the container.
     *
     * @param string $name
     *
     * @return mixed
     */
    function resolve($name)
    {
        return app($name);
    }
}
