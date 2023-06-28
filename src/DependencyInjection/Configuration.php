<?php
declare(strict_types=1);

namespace Flexibill\NavBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Flexibill\NavBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('nav');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->booleanNode('enabled')->defaultTrue()->isRequired()->end()
                ->enumNode('environment')->isRequired()->values([
                    'test',
                    'prod'
                ])->end()
                ->scalarNode('api_url')->isRequired()->end()
                ->arrayNode('software_params')
                    ->isRequired()
                    ->children()
                        ->scalarNode('id')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('name')->isRequired()->cannotBeEmpty()->end()
                        ->enumNode('operation')
                            ->isRequired()
                            ->values([
                                'ONLINE_SERVICE',
                                'LOCAL_SERVICE'
                            ])->end()
                        ->scalarNode('version')->isRequired()->cannotBeEmpty()->end()
                        ->arrayNode('developer')
                            ->isRequired()
                            ->children()
                                ->scalarNode('name')->isRequired()->cannotBeEmpty()->end()
                                ->scalarNode('contact')->isRequired()->cannotBeEmpty()->end()
                                ->scalarNode('country_code')->defaultValue('HU')->end()
                                ->scalarNode('tax_number')->isRequired()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
