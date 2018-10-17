<?php

namespace Imanghafoori\HeyMan\Facades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;
use Imanghafoori\HeyMan\Forget;
use Imanghafoori\HeyMan\MakeSure\HttpClient;
use Imanghafoori\HeyMan\Switching\Consider;
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
 * @method static YouShouldHave whenYouSendGet(array|sting $url)
 * @method static YouShouldHave whenYouSendPost(array|sting $url)
 * @method static YouShouldHave whenYouSendPut(array|sting $url)
 * @method static YouShouldHave whenYouSendPatch(array|sting $url)
 * @method static YouShouldHave whenYouSendDelete(array|sting $url)
 * @method static YouShouldHave whenYouHitRouteName(array|sting $routeName)
 * @method static YouShouldHave whenYouCallAction(array|sting $action)
 * @method static YouShouldHave whenYouMakeView(array|sting $view)
 * @method static YouShouldHave whenEventHappens(array|sting $event)
 * @method static YouShouldHave whenYouReachCheckPoint(array|sting $event)
 * @method static Consider turnOff()
 * @method static null checkPoint(string $name)
 * @method static Consider turnOn()
 * @method static Forget forget()
 * @method static HttpClient makeSure()
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
