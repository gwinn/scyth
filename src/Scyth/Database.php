<?php

/**
 *  Database
 *
 *  PHP Version 5.3
 *
 *  @category Core
 *  @package  Scyth
 *  @author   Alex Lushpai <alex@lushpai.org>
 *  @license  LGPL v.3 http://www.gnu.org/licenses/lgpl.html
 *  @link     http://jtforce.com/scyth/guide/core/database.html
 *
 */

namespace Scyth;

/**
 *  Database base class
 *
 *  @category Core
 *  @package  Scyth
 *  @author   Alex Lushpai <alex@lushpai.org>
 *  @license  LGPL v.3 http://www.gnu.org/licenses/lgpl.html
 *  @link     http://jtforce.com/scyth/guide/index.html
 *
 */

class Database extends PDO
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
        parent::__construct(
            $this->app['config']['db']['driver'] . ':host=' .
            $this->app['config']['db']['host'] . ';dbname=' .
            $this->app['config']['db']['database'],
            $this->app['config']['db']['user'],
            $this->app['config']['db']['password']
        );

        $this->exec("SET NAMES utf8");
        $this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }

}
