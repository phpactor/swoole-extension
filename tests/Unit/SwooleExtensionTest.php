<?php

namespace Phpactor\Extension\Swoole\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Phpactor\Container\PhpactorContainer;
use Phpactor\Extension\ClassToFile\ClassToFileExtension;
use Phpactor\Extension\ComposerAutoloader\ComposerAutoloaderExtension;
use Phpactor\Extension\ExtensionManager\ExtensionManagerExtension;
use Phpactor\Extension\Logger\LoggingExtension;
use Phpactor\Extension\Swoole\SwooleExtension;
use Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor\FilePathResolverExtension\FilePathResolverExtension;
use Phpactor\WorseReflection\Reflector;

class SwooleExtensionTest extends TestCase
{
    public function testRegistration()
    {
        $container = PhpactorContainer::fromExtensions([
            WorseReflectionExtension::class,
            FilePathResolverExtension::class,
            ClassToFileExtension::class,
            ComposerAutoloaderExtension::class,
            LoggingExtension::class,
            SwooleExtension::class,
            ExtensionManagerExtension::class,
        ], [
            'file_path_resolver.application_root' => __DIR__ . '/../..',
             ExtensionManagerExtension::PARAM_EXTENSION_VENDOR_DIR => __DIR__ . '/../../vendor',
        ]);

        $reflector = $container->get(WorseReflectionExtension::SERVICE_REFLECTOR);

        assert($reflector instanceof Reflector);

        $class = $reflector->reflectClass(\Swoole\Http\Client::class);
        $this->assertEquals(\Swoole\Http\Client::class, $class->name());
    }
}
