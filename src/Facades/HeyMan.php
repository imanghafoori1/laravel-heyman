<?php

namespace Imanghafoori\HeyMan\Facades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;
use Imanghafoori\HeyMan\YouShouldHave;

/**
 * Class HeyMan.
 *
 * @method static YouShouldHave whenYouFetch(array|Model $model)
 * @method static YouShouldHave whenYouCreate(array|Model $model)
 * @method static YouShouldHave whenYouUpdate(array|Model $model)
 * @method static YouShouldHave whenYouSave(array|Model $model)
 * @method static YouShouldHave whenYouDelete(array|Model $model)
 * @method static YouShouldHave whenYouVisitUrl(array|sting $url)
 * @method static YouShouldHave whenYouVisitRoute(array|sting $routeName)
 * @method static YouShouldHave whenYouCallAction(array|sting $action)
 * @method static YouShouldHave whenYouViewBlade(array|sting $view)
 * @method static YouShouldHave whenYouMakeView(array|sting $view)
 * @method static YouShouldHave whenEventHappens(array|sting $event)
 *
 * @see \Imanghafoori\HeyMan\HeyMan
 */
class HeyMan extends Facade
{
    public static function getFacadeAccessor()
    {
        return \Imanghafoori\HeyMan\HeyMan::class;
    }
}
