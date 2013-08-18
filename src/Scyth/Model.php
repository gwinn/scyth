<?php

/**
 *  Model
 *
 *  PHP Version 5.3
 *
 *  @category Core
 *  @package  Scyth
 *  @author   Alex Lushpai <alex@lushpai.org>
 *  @license  LGPL v.3 http://www.gnu.org/licenses/lgpl.html
 *  @link     http://jtforce.com/scyth/guide/core/model.html
 *
 */

namespace Scyth;

/**
 *  Model base class
 *
 *  @category Core
 *  @package  Scyth
 *  @author   Alex Lushpai <alex@lushpai.org>
 *  @license  LGPL v.3 http://www.gnu.org/licenses/lgpl.html
 *  @link     http://jtforce.com/scyth/guide/index.html
 *
 */

class Model
{

    protected $app;
    protected $db;

    /**
     * Constructor
     *
     * @access public
     */
    function __construct($app)
    {
        $this->app = $app;
        $this->db = $this->app->get('db');
    }
}
