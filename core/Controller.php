<?php

/**
 *  Controller
 *
 *  PHP Version 5.3
 *
 *  @category Core
 *  @package  Scyth
 *  @author   Alex Lushpai <alex@lushpai.org>
 *  @license  LGPL v.3 http://www.gnu.org/licenses/lgpl.html
 *  @link     http://jtforce.com/scyth/guide/core/controller.html
 *
 */


/**
 *  Controller base class
 *
 *  @category Core
 *  @package  Scyth
 *  @author   Alex Lushpai <alex@lushpai.org>
 *  @license  LGPL v.3 http://www.gnu.org/licenses/lgpl.html
 *  @link     http://jtforce.com/scyth/guide/index.html
 *
 */


abstract class Controller
{
    protected $app;

    /**
     * Constructor
     *
     * @return void
     *
     */

    function __construct($app)
    {
        $this->app = $app;

        $str = explode("/", $_SERVER['REQUEST_URI']);
        $this->app->get('view')->set('layout',  $str[1]);
    }
    
    /**
     * Abstract index
     *
     * @return void
     *
     */

    abstract function index();
    
    /**
    * 404 http error handler
    *
    * @return void
    */

    public function error_404()
    {
        $this->app->get('view')->show('layout','error/404');
    }

}

