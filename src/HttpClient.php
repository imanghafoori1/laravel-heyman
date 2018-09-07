<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;

class HttpClient
{
    use MakesHttpRequests;

    private $http = [];

    private $assertion;

    private $app;

    private $event;

    private $exception;

    /**
     * HttpClient constructor.
     *
     * @param $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    public function sendingPostRequest($url, $data = []): self
    {
        $this->http = [
            'method' => 'post',
            'url' => $url,
            'data' => $data
        ];

        return $this;
    }

    public function forbiddenStatus()
    {
        return $this->statusCode(403);
    }

    public function sendingGetRequest($url): self
    {
        $this->http = [
            'method' => 'get',
            'url' => $url,
            'data' => [],
        ];

        return $this;
    }

    public function isRespondedWith()
    {
        return $this;
    }

    public function isOk()
    {
        $this->assertion[] = ['type' => 'assertSuccessful', 'value' => null];
    }

    public function redirect($url, $status = null)
    {
        $this->assertion[] = ['type' => 'assertRedirect', 'value' => $url];

        if (!is_null($status)) {
            $this->assertion[] = ['type' => 'assertStatus', 'value' => $status];
        }
        return $this;
    }

    public function statusCode($code)
    {
        $this->assertion[] = ['type' => 'assertStatus', 'value' => $code];
        return $this;
    }

    public function success()
    {
        $this->assertion[] = ['type' => 'assertSuccessful', 'value' => null];
    }

    public function withError($value)
    {
        $this->assertion[] = ['type' => 'assertSessionHasErrors', 'value' => $value];
        return $this;
    }

    public function exceptionIsThrown($type)
    {
        $this->exception = $type;
    }

    public function whenEventHappens($event)
    {
        $this->event = $event;
        return $this;
    }

    public function __destruct()
    {
        if ($this->exception) {
            $this->app->expectException($this->exception);
        }
        if ($this->event) {
            event($this->event);
        }
        if(!$this->http){
            return ;
        }
        $method = $this->http['method'];

        $response = $this->app->$method($this->http['url'], $this->http['data']);

        foreach ($this->assertion as $assertion) {
            $type = $assertion['type'];
            $response->$type($assertion['value']);
        }
    }
}