<?php

namespace Imanghafoori\HeyMan;

class Otherwise
{
    public function otherwise(): Actions
    {
        return app(Actions::class);
    }
}
