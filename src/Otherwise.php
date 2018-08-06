<?php

namespace Imanghafoori\HeyMan;

class Otherwise
{
    public function otherwise(): Reactions
    {
        return app(Reactions::class);
    }
}
