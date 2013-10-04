<?php

require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Wj\Shift\Application;

Application::boot();

Application::handle(Request::createFromGlobals());
