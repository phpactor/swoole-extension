<?php

namespace Phpactor\Extension\Swoole\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Phpactor\Container\PhpactorContainer;
use Phpactor\Extension\ClassToFile\ClassToFileExtension;
use Phpactor\Extension\ComposerAutoloader\ComposerAutoloaderExtension;
use Phpactor\Extension\Logger\LoggingExtension;
use Phpactor\Extension\ReferenceFinder\ReferenceFinderExtension;
use Phpactor\Extension\Swoole\SwooleExtension;
use Phpactor\Extension\WorseReferenceFinder\WorseReferenceFinderExtension;
use Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor\FilePathResolverExtension\FilePathResolverExtension;
use Phpactor\ReferenceFinder\DefinitionLocator;
use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\TextDocumentBuilder;
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
        ], [
            'file_path_resolver.application_root' => __DIR__ . '/../..',
        ]);

        $reflector = $container->get(WorseReflectionExtension::SERVICE_REFLECTOR);

        assert($reflector instanceof Reflector);

        $class = $reflector->reflectClass(\Swoole\Http\Client::class);
        $this->assertEquals(\Swoole\Http\Client::class, $class->name());
    }
}
