<?php

namespace Phpactor\Extension\Swoole;

use Phpactor\Container\Container;
use Phpactor\Container\ContainerBuilder;
use Phpactor\Container\Extension;
use Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor\FilePathResolverExtension\FilePathResolverExtension;
use Phpactor\MapResolver\Resolver;
use Phpactor\WorseReflection\Core\SourceCodeLocator\StubSourceLocator;
use Phpactor\WorseReflection\ReflectorBuilder;

class SwooleExtension implements Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(ContainerBuilder $container)
    {
        $container->register('swoole.worse_reflection.stub_locator', function (Container $container) {
            $resolver = $container->get(FilePathResolverExtension::SERVICE_FILE_PATH_RESOLVER);
            $cacheDir = $resolver->resolve($container->getParameter(WorseReflectionExtension::PARAM_STUB_CACHE_DIR));

            return new StubSourceLocator(
                ReflectorBuilder::create()->build(),
                __DIR__ . '/../vendor/eaglewu/swoole-ide-helper',
                $cacheDir
            );
        }, [ WorseReflectionExtension::TAG_SOURCE_LOCATOR => []]);
    }

    /**
     * {@inheritDoc}
     */
    public function configure(Resolver $schema)
    {
    }
}
