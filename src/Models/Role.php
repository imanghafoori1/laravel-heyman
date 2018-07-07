<?php

namespace Imanghafoori\HeyMan\Models;

use Illuminate\Database\Eloquent\Model;
use Imanghafoori\HeyMan\Exceptions\RoleAlreadyExists;
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

    public static function findByName(string $name, $guardName = null)
    {
        $guardName = $guardName ?? GuardManager::getDefaultName(static::class);

        $role = static::where('name', $name)->where('guard_name', $guardName)->first();

        if (! $role) {
            throw RoleDoesNotExist::named($name);
        }

        return $role;
    }

    public static function create(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? GuardManager::getDefaultName(static::class);

        if (static::where('name', $attributes['name'])->where('guard_name', $attributes['guard_name'])->first()) {
            throw RoleAlreadyExists::create($attributes['name'], $attributes['guard_name']);
        }

        if (app()::VERSION < '5.4') {
            return parent::create($attributes);
        }

        return static::query()->create($attributes);
    }

}
