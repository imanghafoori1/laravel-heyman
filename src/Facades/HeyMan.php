<?php

namespace Imanghafoori\HeyMan\Facades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;
use Imanghafoori\HeyMan\YouShouldHave;

/**
 * Class HeyMan
 *
 * @method static YouShouldHave whenFetching(array|Model $model)
 * @method static YouShouldHave whenCreating(array|Model $model)
 * @method static YouShouldHave whenUpdating(array|Model $model)
 * @method static YouShouldHave whenSaving(array|Model $model)
 * @method static YouShouldHave whenDeleting(array|Model $model)
 * @method static YouShouldHave whenYouVisitUrl(array|sting $url)
 * @method static YouShouldHave whenYouVisitRoute(array|sting $routeName)
 * @method static YouShouldHave whenYouCallAction(array|sting $action)
 * @method static YouShouldHave whenViewMake(array|sting $view)
 * @method static YouShouldHave whenEventHappens(array|sting $event)
 *
 *
 * @package Imanghafoori\HeyMan\Facades
 */
class HeyMan extends Facade
{
    public static function getFacadeAccessor()
    {
        return \Imanghafoori\HeyMan\HeyMan::class;
    }
}