<?php

namespace Imanghafoori\HeyMan;

class Responder
{
    private $action;

    /**
     * Responder constructor.
     *
     * @param $action
     */
    public function __construct($action)
    {
        $this->action = $action;
    }

    /**
     * @return \Imanghafoori\HeyMan\RedirectionMsg
     */
    /*    public function redirect(): RedirectionMsg
        {
            $this->action->response[] = ['redirectTo', func_get_args()];
    
            HeyMan::whenYouVisitUrl('/login')
                ->youShouldBeGuest()
                ->otherwise()
                ->redirectTo('/');
    
            return new RedirectionMsg($this);
        }*/

    /**
     * Return a new response from the application.
     *
     * @param string $content
     * @param int    $status
     * @param array  $headers
     */
    public function make($content = '', $status = 200, array $headers = [])
    {
        $this->action->response[] = ['make', func_get_args()];
    }

    /**
     * Return a new view response from the application.
     *
     * @param string $view
     * @param array  $data
     * @param int    $status
     * @param array  $headers
     */
    public function view($view, $data = [], $status = 200, array $headers = [])
    {
        $this->action->response[] = ['view', func_get_args()];
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
        $this->action->response[] = ['json', func_get_args()];
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
        $this->action->response[] = ['jsonp', func_get_args()];
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
        $this->action->response[] = ['stream', func_get_args()];
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
        $this->action->response[] = ['streamDownload', func_get_args()];
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
        $this->action->response[] = ['download', func_get_args()];
    }
}
