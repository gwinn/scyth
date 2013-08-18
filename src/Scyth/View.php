<?php

/**
 *  View
 *
 *  PHP Version 5.3
 *
 *  @category Core
 *  @package  Scyth
 *  @author   Alex Lushpai <alex@lushpai.org>
 *  @license  LGPL v.3 http://www.gnu.org/licenses/lgpl.html
 *  @link     http://jtforce.com/scyth/guide/core/view.html
 *
 */


namespace Scyth;

/**
 *  View base class
 *
 *  @category Core
 *  @package  Scyth
 *  @author   Alex Lushpai <alex@lushpai.org>
 *  @license  LGPL v.3 http://www.gnu.org/licenses/lgpl.html
 *  @link     http://jtforce.com/scyth/guide/index.html
 *
 */
class View
{

    private $app;
    private $vars = array();

    function __construct($app)
    {
        $this->app = $app;
    }

    function set($varname, $value, $overwrite=false)
    {
        if (isset($this->vars[$varname]) && $overwrite)
        {
            trigger_error('Unable to set var `' . $varname . '`. Already set, and overwrite not allowed.', E_USER_NOTICE);
            return false;
        }

        $this->vars[$varname] = $value;
        return true;
    }

    function remove($varname)
    {
        unset($this->vars[$varname]);
        return true;
    }

    function show($layout, $name)
    {
        $wrap = APP_PATH . 'views' . DIR_SEP . 'layouts' . DIR_SEP . $layout . '.php';
        $path = APP_PATH . 'views' . DIR_SEP . $name . '.php';

        if (!file_exists($path) && !file_exists($wrap)) {
            trigger_error ('Template `' . $name . '` does not exist.', E_USER_NOTICE);
            return false;
        }

        // Load variables
        foreach ($this->vars as $key => $value) {
            $$key = $value;
        }

        $content = $path;
        include $wrap;
    }

}
