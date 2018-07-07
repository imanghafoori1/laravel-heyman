<?php

namespace Imanghafoori\HeyMan\Models;

use Imanghafoori\HeyMan\Utils\GuardManager;

trait HasRoles
{
    protected function getDefaultGuardName(): string
    {
        return GuardManager::getDefaultName($this);
    }

}
