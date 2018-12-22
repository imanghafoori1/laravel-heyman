<?php

namespace Imanghafoori\HeyMan\MakeSure;

class HttpClient
{
    private $chain;

    private $methods = [
        'sendingPostRequest'       => 'post',
        'sendingJsonPostRequest'   => 'postJson',
        'sendingDeleteRequest'     => 'delete',
        'sendingJsonDeleteRequest' => 'deleteJson',
        'sendingPutRequest'        => 'put',
        'sendingJsonPutRequest'    => 'putJson',
        'sendingPatchRequest'      => 'patch',
        'sendingJsonPatchRequest'  => 'patchJson',
        'sendingGetRequest'        => 'get',
        'sendingJsonGetRequest'    => 'getJson',
    ];

    /**
     * HttpClient constructor.
     *
     * @param $phpunit
     */
    public function __construct($phpunit)
    {
        $this->chain = new Chain($phpunit);
    }

    public function __call($method, $params)
    {
        return $this->sendRequest($method, ...$params);
    }

    public function sendRequest($method, ...$data): IsRespondedWith
    {
        $this->chain->http($this->methods[$method], ...$data);

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
