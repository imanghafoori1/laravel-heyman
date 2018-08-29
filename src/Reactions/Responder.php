<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\Chain;

class Responder
{
    private $chain;

    private $action;

    /**
     * Responder constructor.
     *
     * @param \Imanghafoori\HeyMan\Chain $chain
     * @param $action
     */
    public function __construct(Chain $chain, $action)
    {
        $this->chain = $chain;
        $this->action = $action;
    }

    /**
     * Return a new response from the application.
     *
     * @param string $content
     * @param int    $status
     * @param array  $headers
     */
    public function make(string $content = '', int $status = 200, array $headers = [])
    {
        $this->chain->commitArray([__FUNCTION__, func_get_args()], 'response');
    }

    /**
     * Return a new view response from the application.
     *
     * @param string $view
     * @param array  $data
     * @param int    $status
     * @param array  $headers
     */
    public function view(string $view, array $data = [], int $status = 200, array $headers = [])
    {
        $this->chain->commitArray([__FUNCTION__, func_get_args()], 'response');
    }

    /**
     * Return a new JSON response from the application.
     *
     * @param string|array $data
     * @param int          $status
     * @param array        $headers
     * @param int          $options
     */
    public function json($data = [], $status = 200, array $headers = [], $options = 0)
    {
        $this->chain->commitArray([__FUNCTION__, func_get_args()], 'response');
    }

    /**
     * Return a new JSONP response from the application.
     *
     * @param string       $callback
     * @param string|array $data
     * @param int          $status
     * @param array        $headers
     * @param int          $options
     */
    public function jsonp($callback, $data = [], $status = 200, array $headers = [], $options = 0)
    {
        $this->chain->commitArray([__FUNCTION__, func_get_args()], 'response');
    }

    /**
     * Return a new streamed response from the application.
     *
     * @param \Closure $callback
     * @param int      $status
     * @param array    $headers
     */
    public function stream($callback, $status = 200, array $headers = [])
    {
        $this->chain->commitArray([__FUNCTION__, func_get_args()], 'response');
    }

    /**
     * Return a new streamed response as a file download from the application.
     *
     * @param \Closure    $callback
     * @param string|null $name
     * @param array       $headers
     * @param string|null $disposition
     */
    public function streamDownload($callback, $name = null, array $headers = [], $disposition = 'attachment')
    {
        $this->chain->commitArray([__FUNCTION__, func_get_args()], 'response');
    }

    /**
     * Create a new file download response.
     *
     * @param \SplFileInfo|string $file
     * @param string|null         $name
     * @param array               $headers
     * @param string|null         $disposition
     */
    public function download($file, $name = null, array $headers = [], $disposition = 'attachment')
    {
        $this->chain->commitArray([__FUNCTION__, func_get_args()], 'response');
    }
}
