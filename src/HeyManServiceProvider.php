<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\Boot\Singletons;
use Imanghafoori\HeyMan\Boot\DebugbarIntergrator;
use Imanghafoori\HeyMan\Conditions\ConditionsFacade;
use Imanghafoori\HeyMan\Conditions\Traits\Callbacks;
use Imanghafoori\HeyMan\Conditions\Traits\Authentication;
use Imanghafoori\HeyMan\Conditions\Traits\Gate as myGate;
use Imanghafoori\HeyMan\Conditions\Traits\Session as mySession;

final class HeyManServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->defineGates();

        $this->loadMigrationsFrom(__DIR__.'/migrations');
        app()->booted([resolve(StartGuarding::class), 'start']);

        $this->disableIfIsSeeding();
        DebugbarIntergrator::register();

        $this->registerConditions();
    }

    public function register()
    {
        Singletons::make($this->app);

        AliasLoader::getInstance()->alias('HeyMan', \Imanghafoori\HeyMan\Facades\HeyMan::class);

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
}
