<?php

namespace Phpactor\Extension\Swoole;

use Phpactor\Container\Container;
use Phpactor\Container\ContainerBuilder;
use Phpactor\Container\Extension;
use Phpactor\Extension\ExtensionManager\ExtensionManagerExtension;
use Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor\FilePathResolverExtension\FilePathResolverExtension;
use Phpactor\MapResolver\Resolver;
use Phpactor\WorseReflection\Core\SourceCodeLocator\StubSourceLocator;
use Phpactor\WorseReflection\ReflectorBuilder;

class SwooleExtension implements Extension
{
    private const IDE_HELPER_PATH = '/eaglewu/swoole-ide-helper';

    /**
     * {@inheritDoc}
     */
    public function load(ContainerBuilder $container)
    {
        $container->register('swoole.worse_reflection.stub_locator', function (Container $container) {
            $resolver = $container->get(FilePathResolverExtension::SERVICE_FILE_PATH_RESOLVER);

            return new StubSourceLocator(
                ReflectorBuilder::create()->build(),
                $container->getParameter(ExtensionManagerExtension::PARAM_EXTENSION_VENDOR_DIR) . self::IDE_HELPER_PATH,
                $resolver->resolve($container->getParameter(WorseReflectionExtension::PARAM_STUB_CACHE_DIR))
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
