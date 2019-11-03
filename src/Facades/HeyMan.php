<?php

namespace Imanghafoori\HeyMan\Facades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;
use Imanghafoori\HeyMan\Core\Condition;
use Imanghafoori\HeyMan\Forget;
use Imanghafoori\HeyMan\Switching\Consider;

/**
 * Class HeyMan.
 *
 * @method static Condition whenYouFetch(array|Model $model)
 * @method static Condition whenYouCreate(array|Model $model)
 * @method static Condition whenYouUpdate(array|Model $model)
 * @method static Condition whenYouSave(array|Model $model)
 * @method static Condition whenYouDelete(array|Model $model)
 * @method static Condition whenYouVisitUrl(array|string $url)
 * @method static Condition whenYouSendGet(array|string $url)
 * @method static Condition whenYouSendPost(array|string $url)
 * @method static Condition whenYouSendPut(array|string $url)
 * @method static Condition whenYouSendPatch(array|string $url)
 * @method static Condition whenYouSendDelete(array|string $url)
 * @method static Condition whenYouHitRouteName(array|string $routeName)
 * @method static Condition onRoute(array|string $routeName)
 * @method static Condition whenYouCallAction(array|string $action)
 * @method static Condition whenEventHappens(array|string $event)
 * @method static Condition whenYouReachCheckPoint(array|string $event)
 * @method static Condition onCheckPoint(array|string $event)
 * @method static Consider turnOff()
 * @method static null checkPoint(string $name)
 * @method static Consider turnOn()
 * @method static Forget forget()
 * @method static void defineCondition(string $name, $callable)
 * @method static void defineReaction($methodName, $callable)
 * @method static void aliasCondition(string $currentName, string $newName)
 * @method static void aliasSituation(string $currentName, string $newName)
 * @method static void aliasReaction(string $currentName, string $newName)
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
