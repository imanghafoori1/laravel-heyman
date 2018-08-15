<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Imanghafoori\HeyMan\HeyManSwitcher;

class ViewEventManager
{
    private $views = [];

    private $data = [];

    /**
     * ViewEventManager constructor.
     *
     * @param $views
     *
     * @return ViewEventManager
     */
    public function init(array $views): self
    {
        $this->views = $views;

        return $this;
    }

    /**
     * @param $listener
     */
    public function commitChain(callable $listener)
    {
        $switchableListener = app(HeyManSwitcher::class)->wrapForIgnorance($listener, 'view');
        $views = $this->views;
        foreach ($views as $view) {
            $this->data[$view][] = $switchableListener;
        }
    }

    public function start()
    {
        foreach ($this->data as $value => $callbacks) {
            foreach ($callbacks as $key => $cb) {
                $this->register($value, $cb);
            }
        }
    }

    public function forgetAbout($views)
    {
        foreach ($views as $view) {
            unset($this->data[$view]);
        }
    }

    public function forgetAboutAll()
    {
        $this->data = [];
    }

    public function register($view, $callback)
    {
        view()->creator($view, $callback);
    }
}
