<?php

namespace Imanghafoori\HeyMan\Models;

use Illuminate\Database\Eloquent\Model;
use Imanghafoori\HeyMan\Utils\GuardManager;

class Role extends Model
{
    public $guarded = ['id'];

    public static function findById(int $id, $guardName = null)
    {
        $guardName = $guardName ?? GuardManager::getDefaultName(static::class);

        $role = static::where('id', $id)->where('guard_name', $guardName)->first();

        if (! $role) {
            throw RoleDoesNotExist::withId($id);
        }

        return $role;
    }
}
