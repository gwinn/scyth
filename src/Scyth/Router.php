<?php

namespace Scyth;

class Router
{
    private $app;
    private $path;
    private $args = array();

    function __construct($app)
    {
        $this->app = $app;
    }

    function setPath($path)
    {
        $path = trim($path, '/\\/');
        $path .= DIR_SEP;

        if (!is_dir($path))
        {
            throw new Exception ('Invalid controller path: `' . $path . '`');
        }

        $this->path = $path;
    }

    private function getController(&$file, &$controller, &$action, &$args)
    {
        $route = (empty($_GET['route'])) ? '' : $_GET['route'];

        if (empty($route))
        {
            $route = 'scyth';
        }

        $route = trim($route, '/\\');
        $parts = explode('/', $route);

        // Find controller

        $cmd_path = $this->path;
        foreach ($parts as $part)
        {
            $fullpath = $cmd_path . $part;

            // Find dir
            if (is_dir($fullpath))
            {
                $cmd_path .= $part . DIR_SEP;
                array_shift($parts);
                continue;
            }

            // Find file
            if (is_file($fullpath . '.php'))
            {
                $controller = $part;
                array_shift($parts);
                break;
            }
        }

        if (empty($controller))
        {
            $controller = 'scyth';
        };

        //get action
        $action = array_shift($parts);

        if(empty($action))
        {
            $action = 'index';
        }

        $file = $cmd_path . $controller . '.php';
        $args = $parts;
    }

    function run()
    {
        $this->getController($file, $controller, $action, $args);

        if (!is_readable($file))
        {
            http_redirect('error_404');
        }

        // Include file
        include ($file);

        // Making controller instance
        $class = 'Controller_' . $controller;
        $controller = new $class($this->app);


        // Is action available?
        if (!is_callable(array($controller, $action)))
        {
            http_redirect('error_404');
        }

        // Making action
        $controller->$action();
    }

}
