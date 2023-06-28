<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class NavExtension
 * @package Flexibill\NavBundle\DependencyInjection
 */
class NavExtension extends Extension
{
    const ENV_TEST = 'test';
    const ENV_PROD = 'prod';

    // @todo move to config
    const DEFAULT = 'https://api-test.onlineszamla.nav.gov.hu/invoiceService';

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        $config = $processor->processConfiguration($configuration, $configs);

        $container->setParameter('nav_module_enable', $config['enabled']);
        $container->setParameter('nav_module_environment', $config['environment']);
        $container->setParameter('nav_module_software_params', $config['software_params']);
        $container->setParameter('nav_module_api_url', $config['api_url']);
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     * @return Configuration|null|object|\Symfony\Component\Config\Definition\ConfigurationInterface
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new Configuration();
    }


}