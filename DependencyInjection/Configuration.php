<?php

/**
 *  Configuration
 *
 *  PHP Version 5.5
 *
 *  @category Symfony
 *  @package  Scyth
 *  @author   Alex Lushpai <alex@lushpai.org>
 *  @license  MIT http://opensource.org/licenses/MIT
 *  @link     https://github.com/gwinn/ScythBundle/blob/master/README.md
 *
 */

namespace Gwinn\ScythBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 *  Configuration class
 *
 *  @category Symfony
 *  @package  Scyth
 *  @author   Alex Lushpai <alex@lushpai.org>
 *  @license  MIT http://opensource.org/licenses/MIT
 *  @link     https://github.com/gwinn/ScythBundle/blob/master/README.md
 *
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Get configuration
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('gwinn_scyth');

        return $treeBuilder;
    }
}