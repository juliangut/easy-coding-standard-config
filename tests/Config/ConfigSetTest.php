<?php

/*
 * (c) 2021-2026 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

namespace Jgut\ECS\Tests\Config;

use Jgut\ECS\Config\AbstractConfigSet;
use Jgut\ECS\Config\ConfigSet82;
use Jgut\ECS\Config\ConfigSet83;
use Jgut\ECS\Config\ConfigSet84;
use Lcobucci\Clock\SystemClock;
use PHP_CodeSniffer\Sniffs\Sniff;
use PhpCsFixer\Fixer\FixerInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

/**
 * @internal
 */
final class ConfigSetTest extends TestCase
{
    /**
     * @return iterable<string, array{class-string<AbstractConfigSet>, string}>
     */
    public static function provideConfigSet(): iterable
    {
        yield 'ConfigSet82' => [ConfigSet82::class, '8.2.0'];
        yield 'ConfigSet83' => [ConfigSet83::class, '8.3.0'];
        yield 'ConfigSet84' => [ConfigSet84::class, '8.4.0'];
    }

    /**
     * Rules are gated on installed package versions, a wrong gate registers a non existing rule.
     *
     * @param class-string<AbstractConfigSet> $configSetClass
     */
    #[DataProvider('provideConfigSet')]
    public function testConfiguredRulesAreInstalled(string $configSetClass, string $requiredPhpVersion): void
    {
        $configSet = self::getConfigSet($configSetClass, $requiredPhpVersion);

        /** @var array<string, array<string, mixed>|bool> $rules */
        $rules = (new ReflectionMethod($configSet, 'getRules'))->invoke($configSet);

        self::assertNotEmpty($rules);

        foreach (array_keys($rules) as $rule) {
            self::assertTrue(class_exists($rule), \sprintf('Rule "%s" is not installed.', $rule));
            self::assertTrue(
                is_a($rule, FixerInterface::class, true) || is_a($rule, Sniff::class, true),
                \sprintf('Rule "%s" is neither a fixer nor a sniff.', $rule),
            );
        }
    }

    /**
     * @param class-string<AbstractConfigSet> $configSetClass
     */
    #[DataProvider('provideConfigSet')]
    public function testBuilderIsConfigured(string $configSetClass, string $requiredPhpVersion): void
    {
        $this->expectNotToPerformAssertions();

        self::getConfigSet($configSetClass, $requiredPhpVersion)->configureBuilder();
    }

    public function testHeaderPlaceholdersAreReplaced(): void
    {
        $year = SystemClock::fromSystemTimezone()->now()->format('Y');
        $configSet = (new ConfigSet82())->setHeader('(c) {{year}} {{package}}');

        self::assertSame(
            \sprintf('(c) %s juliangut/easy-coding-standard-config', $year),
            (new ReflectionMethod($configSet, 'getHeader'))->invoke($configSet),
        );
    }

    public function testHeaderYearRangeIsCollapsed(): void
    {
        $year = SystemClock::fromSystemTimezone()->now()->format('Y');
        $configSet = (new ConfigSet82())->setHeader(\sprintf('(c) %s-{{year}} package', $year));

        self::assertSame(
            \sprintf('(c) %s package', $year),
            (new ReflectionMethod($configSet, 'getHeader'))->invoke($configSet),
        );
    }

    public function testPhpVersionIsCompared(): void
    {
        $configSet = new ConfigSet82();

        self::assertTrue((new ReflectionMethod($configSet, 'isMinPhpVersion'))->invoke($configSet, '8.2.0'));
        self::assertFalse((new ReflectionMethod($configSet, 'isMinPhpVersion'))->invoke($configSet, '99.0.0'));
        self::assertTrue((new ReflectionMethod($configSet, 'isMaxPhpVersion'))->invoke($configSet, '99.0.0'));
        self::assertFalse((new ReflectionMethod($configSet, 'isMaxPhpVersion'))->invoke($configSet, '8.0.0'));
    }

    /**
     * @param class-string<AbstractConfigSet> $configSetClass
     */
    private static function getConfigSet(string $configSetClass, string $requiredPhpVersion): AbstractConfigSet
    {
        if (version_compare(\PHP_VERSION, $requiredPhpVersion, '<')) {
            self::markTestSkipped(\sprintf('"%s" requires PHP %s.', $configSetClass, $requiredPhpVersion));
        }

        return new $configSetClass();
    }
}
