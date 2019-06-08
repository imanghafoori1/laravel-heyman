<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\Boot\Singletons;
use Imanghafoori\HeyMan\Core\Situations;
use Imanghafoori\HeyMan\Switching\Consider;
use Imanghafoori\HeyMan\Boot\DebugbarIntergrator;
use Imanghafoori\HeyMan\Conditions\ConditionsFacade;
use Imanghafoori\HeyMan\Conditions\Traits\Callbacks;
use Imanghafoori\HeyMan\Conditions\Traits\Authentication;
use Imanghafoori\HeyMan\Conditions\Traits\Gate as myGate;
use Imanghafoori\HeyMan\Conditions\Traits\Session as mySession;
use Imanghafoori\HeyMan\WatchingStrategies\Views\ViewSituationProvider;
use Imanghafoori\HeyMan\WatchingStrategies\Events\EventSituationProvider;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouteSituationProvider;
use Imanghafoori\HeyMan\WatchingStrategies\EloquentModels\EloquentSituationProvider;

final class HeyManServiceProvider extends ServiceProvider
{
    public $situationProviders = [
        ViewSituationProvider::class,
        RouteSituationProvider::class,
        EventSituationProvider::class,
        EloquentSituationProvider::class,
    ];

    public function boot()
    {
        $this->defineGates();

        app()->booted([resolve(StartGuarding::class), 'start']);

        $this->disableIfIsSeeding();
        DebugbarIntergrator::register();

        $this->registerConditions();

        $this->registerSituationProviders($this->situationProviders);
    }

    public function register()
    {
        Singletons::make($this->app);

        AliasLoader::getInstance()->alias('HeyMan', HeyMan::class);

        $this->mergeConfigFrom(__DIR__.'/../config/heyMan.php', 'heyMan');
    }

    private function defineGates()
    {
        Gate::define('heyman.youShouldHaveRole', function ($user, $role) {
            return $user->role == $role;
        });
    }

    private function disableIfIsSeeding()
    {
        if (isset(\Request::server('argv')[1]) && \Request::server('argv')[1] == 'db:seed') {
            HeyMan::turnOff()->eloquentChecks();
        }
    }

    private function registerConditions()
    {
        app(ConditionsFacade::class)->define('youShouldBeGuest', Authentication::class.'@beGuest');
        app(ConditionsFacade::class)->define('youShouldBeLoggedIn', Authentication::class.'@loggedIn');

        app(ConditionsFacade::class)->define('thisClosureShouldAllow', Callbacks::class.'@closureAllows');
        app(ConditionsFacade::class)->define('thisMethodShouldAllow', Callbacks::class.'@methodAllows');
        app(ConditionsFacade::class)->define('thisValueShouldAllow', Callbacks::class.'@valueAllows');

        app(ConditionsFacade::class)->define('thisGateShouldAllow', myGate::class.'@thisGateShouldAllow');
        app(ConditionsFacade::class)->define('youShouldHaveRole', myGate::class.'@youShouldHaveRole');

        app(ConditionsFacade::class)->define('sessionShouldHave', mySession::class.'@sessionHas');
    }

    private function registerSituationProviders($providers)
    {
        foreach ($providers as $provider) {
            $provider = new $provider;
            $listener = $provider->getListener();
            $situation = $provider->getSituationProvider();

            app()->singleton($listener);
            app()->singleton($situation);

            Consider::add($provider->getForgetKey(), $listener);
            Situations::add($listener, $situation, $provider->getMethods());
        }
    }
}
