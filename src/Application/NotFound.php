<?php
namespace Application;

// borrowed from https://github.com/weierophinney/mwop.net/blob/master/src/NotFound.php

class NotFound
{
    public function __invoke($req, $res, $next)
    {
        return $next($req, $res->withStatus(404), 'Not Found');
    }
}
