<?php

namespace Semver\Services\Error;

use Whoops\Handler\Handler;

class SimplePageHandler extends Handler
{
    /**
     * @return int
     */
    public function handle()
    {
        echo 'Something went wrong!';

        return Handler::QUIT;
    }
}
