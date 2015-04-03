<?php
namespace Semver\Services\Error;

use ErrorException;
use Exception;
use League\Container\ServiceProvider as BaseServiceProvider;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Run::class,
    ];

    /**
     * Boot method.
     */
    public function boot()
    {
        set_error_handler(function ($level, $message, $file = '', $line = 0, $context = []) {
            if (error_reporting() & $level) {
                throw new ErrorException($message, 0, $level, $file, $line);
            }
        });

        set_exception_handler(function (Exception $exception) {
            $this->container->call(function (Run $whoops) use ($exception) {
                $whoops->handleException($exception);
            });
        });
    }

    /**
     * Register method.
     */
    public function register()
    {
        $this->container->add('Whoops\Run', function () {
            $whoops = new Run();
            $whoops->pushHandler(new PrettyPageHandler());
            return $whoops;
        });
    }
}