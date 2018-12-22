<?php

namespace Imanghafoori\HeyMan\MakeSure;

class HttpClient
{
    public $app;

    private $chain;

    /**
     * HttpClient constructor.
     *
     * @param $phpunit
     */
    public function __construct($phpunit)
    {
        $this->chain = new Chain($phpunit);
    }

    public function sendingPostRequest(...$data): IsRespondedWith
    {
        $this->chain->http('post', ...$data);

        return new IsRespondedWith($this->chain);
    }

    public function sendingJsonPostRequest(...$data): IsRespondedWith
    {
        $this->chain->http('postJson', ...$data);

        return new IsRespondedWith($this->chain);
    }

    public function sendingDeleteRequest(...$data) : IsRespondedWith
    {
        $this->chain->http('delete', ...$data);

        return new IsRespondedWith($this->chain);
    }

    public function sendingJsonDeleteRequest(...$data) : IsRespondedWith
    {
        $this->chain->http('deleteJson', ...$data);

        return new IsRespondedWith($this->chain);
    }

    public function sendingPutRequest(...$data) : IsRespondedWith
    {
        $this->chain->http('put', ...$data);

        return new IsRespondedWith($this->chain);
    }

    public function sendingJsonPutRequest(...$data) : IsRespondedWith
    {
        $this->chain->http('putJson', ...$data);

        return new IsRespondedWith($this->chain);
    }

    public function sendingPatchRequest(...$data) : IsRespondedWith
    {
        $this->chain->http('patch', ...$data);

        return new IsRespondedWith($this->chain);
    }

    public function sendingJsonPatchRequest(...$data) : IsRespondedWith
    {
        $this->chain->http('patchJson', ...$data);

        return new IsRespondedWith($this->chain);
    }

    public function sendingGetRequest(...$data): IsRespondedWith
    {
        $this->chain->http('get', ...$data);

        return new IsRespondedWith($this->chain);
    }

    public function sendingJsonGetRequest(...$data): IsRespondedWith
    {
        $this->chain->http('getJson', ...$data);

        return new IsRespondedWith($this->chain);
    }

    public function exceptionIsThrown($type)
    {
        $this->chain->data['exception'] = $type;
    }

    public function whenEventHappens($event)
    {
        $this->chain->data['event'] = $event;

        return $this;
    }
}
