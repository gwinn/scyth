<?php

/**
 *  GwinnScythExtension
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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 *  GwinnScythExtension
 *
 *  @category Symfony
 *  @package  Scyth
 *  @author   Alex Lushpai <alex@lushpai.org>
 *  @license  MIT http://opensource.org/licenses/MIT
 *  @link     https://github.com/gwinn/ScythBundle/blob/master/README.md
 *
 */
class GwinnScythExtension extends Extension
{
    /**
     * Configuration loader
     *
     * @param array            $configs   app configurations
     * @param ContainerBuilder $container app container
     *
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services.yml');
    }
}