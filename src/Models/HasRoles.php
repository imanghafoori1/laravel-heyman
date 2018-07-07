<?php

namespace Imanghafoori\HeyMan\Models;

use Imanghafoori\HeyMan\Exceptions\GuardDoesNotMatch;
use Imanghafoori\HeyMan\Utils\GuardManager;

trait HasRoles
{
    protected function getStoredRole($role): Role
    {
        if (is_numeric($role)) {
            return app(Role::class)->findById($role, $this->getDefaultGuardName());
        }

        if (is_string($role)) {
            return app(Role::class)->findByName($role, $this->getDefaultGuardName());
        }

        return $role;
    }

    protected function getGuardNames(): Collection
    {
        return GuardManager::getNames($this);
    }

    protected function getDefaultGuardName(): string
    {
        return GuardManager::getDefaultName($this);
    }

    protected function ensureModelSharesGuard($roleOrPermission)
    {
        if (! $this->getGuardNames()->contains($roleOrPermission->guard_name)) {
            throw GuardDoesNotMatch::create($roleOrPermission->guard_name, $this->getGuardNames());
        }
    }

}
