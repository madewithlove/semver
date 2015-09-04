<?php
namespace Semver\Http\Controllers;

use League\Plates\Engine;

class HomeController
{
    /**
     * @var Engine
     */
    private $views;

    /**
     * @param Engine $views
     */
    public function __construct(Engine $views)
    {
        $this->views = $views;
    }

    /**
     * @return string
     */
    public function index()
    {
        return $this->views->render('index');
    }
}
