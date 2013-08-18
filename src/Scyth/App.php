<?php

namespace Scyth;

class App implements ArrayAccess
{
    private $vars = array();
    private static $instance = null;
    private function __clone() {}

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function get($key)
    {
        if (isset($this->vars[$key]) == false)
        {
            return null;
        }
        return $this->vars[$key];
    }

    function set($key, $var) {
        if (isset($this->vars[$key]) == true)
        {
            throw new Exception('Unable to set `' . $key . '`. Already set.');
        }
        $this->vars[$key] = $var;
        return true;
    }

    function remove($key)
    {
        unset($this->vars[$key]);
    }

    function offsetExists($offset) {
        return isset($this->vars[$offset]);
    }

    function offsetGet($offset) {
        return $this->get($offset);
    }

    function offsetSet($offset, $value) {
        $this->set($offset, $value);
    }

    function offsetUnset($offset) {
        unset($this->vars[$offset]);
    }

}
