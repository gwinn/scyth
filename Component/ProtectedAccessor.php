<?php

/**
 *  ProtectedAccessor
 *
 *  PHP Version 5.5
 *
 *  @category Component
 *  @package  Scyth
 *  @author   Alex Lushpai <alex@lushpai.org>
 *  @license  MIT http://opensource.org/licenses/MIT
 *  @link     https://github.com/gwinn/ScythBundle/blob/master/README.md
 *
 */

namespace Scyth\Component;

/**
 *  ProtectedAccessor class
 *
 *  @category Component
 *  @package  Scyth
 *  @author   Alex Lushpai <alex@lushpai.org>
 *  @license  MIT http://opensource.org/licenses/MIT
 *  @link     https://github.com/gwinn/ScythBundle/blob/master/README.md
 *
 */

class ProtectedAccessor
{

    /**
     * Access to protected property
     *
     * @param object $object  initalized object
     * @param string $prop    property name
     *
     * @return mixed property value
     */
    public function getProtectedProperty($object, $prop)
    {
        $reflectedClass = new \ReflectionClass($object);
        $property = $reflectedClass->getProperty($prop);
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}
