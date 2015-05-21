<?php
namespace Application;

// idea from https://github.com/weierophinney/mwop.net/blob/master/src/ErrorHandler.php


class ErrorHandler
{
    private $view_path;
    private $displayErrors;

    public function __construct($view_path, $displayErrors = false)
    {
        $this->view_path = $view_path;
        $this->displayErrors = (bool) $displayErrors;
    }

    public function __invoke($err, $req, $res, $next)
    {
        if ($res->getStatusCode() === 404) {
            $res->getBody()->attach(fopen($this->view_path.'/error/404.html', 'r'));
            $res->end();
            return $res;
        }

        if ($res->getStatusCode() < 400) {
            $res = $res->withStatus(500);
        }

        $error = $err;

        if (is_array($err)) {
            $error = json_encode($err, JSON_PRETTY_PRINT);
        }

        if ($err instanceof \Exception) {
            $error = $err->getTraceAsString();
        }

        if (is_object($err)) {
            $error = (string) $err;
        }

        $error_message = $this->displayErrors ? "<pre>$error</pre>" : '';
        return $res->end($error_message);
    }
}
