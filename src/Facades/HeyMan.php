<?php

namespace Imanghafoori\HeyMan\Facades;

use Imanghafoori\HeyMan\Forget;
use Illuminate\Support\Facades\Facade;
use Imanghafoori\HeyMan\YouShouldHave;
use Illuminate\Database\Eloquent\Model;
use Imanghafoori\HeyMan\Switching\Consider;

/**
 * Class HeyMan.
 *
 * @method static YouShouldHave whenYouFetch(array|Model $model)
 * @method static YouShouldHave whenYouCreate(array|Model $model)
 * @method static YouShouldHave whenYouUpdate(array|Model $model)
 * @method static YouShouldHave whenYouSave(array|Model $model)
 * @method static YouShouldHave whenYouDelete(array|Model $model)
 * @method static YouShouldHave whenYouVisitUrl(array|string $url)
 * @method static YouShouldHave whenYouSendGet(array|string $url)
 * @method static YouShouldHave whenYouSendPost(array|string $url)
 * @method static YouShouldHave whenYouSendPut(array|string $url)
 * @method static YouShouldHave whenYouSendPatch(array|string $url)
 * @method static YouShouldHave whenYouSendDelete(array|string $url)
 * @method static YouShouldHave whenYouHitRouteName(array|string $routeName)
 * @method static YouShouldHave whenYouCallAction(array|string $action)
 * @method static YouShouldHave whenYouMakeView(array|string $view)
 * @method static YouShouldHave whenEventHappens(array|string $event)
 * @method static YouShouldHave whenYouReachCheckPoint(array|string $event)
 * @method static Consider turnOff()
 * @method static null checkPoint(string $name)
 * @method static Consider turnOn()
 * @method static Forget forget()
 * @method static void defineCondition(string $name, $callable)
 * @method static void aliasCondition(string $currentName, string $newName)
 * @method static void aliasSituation(string $currentName, string $newName)
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
