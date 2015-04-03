<?php
namespace Semver\Http\Controllers;

use League\Plates\Engine;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    /**
     * @type Engine
     */
    private $views;

    /**
     * @param Engine $views
     */
    public function __construct(Engine $views)
    {
        $this->views = $views;
    }

    public function index()
    {
        $content = $this->views->render('index');

        return new Response($content);
    }
}
