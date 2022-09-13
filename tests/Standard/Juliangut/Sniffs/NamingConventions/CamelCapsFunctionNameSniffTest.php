<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

namespace Jgut\ECS\Fixer\Tests\Standard\Juliangut\Sniffs\NamingConventions;

use Jgut\ECS\Fixer\Tests\Standard\AbstractSniffTestCase;

final class CamelCapsFunctionNameSniffTest extends AbstractSniffTestCase
{
    /**
     * @dataProvider sniffProvider
     *
     * @param array<string, mixed> $sniffProperties
     */
    public function testSniff(
        string $filePath,
        array $sniffProperties,
        ?int $line = null,
        ?string $code = null,
        ?string $message = null
    ): void {
        $file = $this->checkFile($filePath, $sniffProperties);

        if ($line === null) {
            self::assertNoSniffErrors($file);
        } elseif ($code === null) {
            self::assertNoSniffError($file, $line);
        } else {
            self::assertSniffError($file, $line, $code, $message);
        }
    }

    public function sniffProvider(): array
    {
        return array_merge(
            $this->getSniffTestsFixed(),
            $this->getSniffTestsDoubleUnderscore(),
            $this->getSniffTestsVisibility(),
            $this->getSniffTestsKebabCase(),
            $this->getSniffTestsDoubleUppercase(),
        );
    }

    protected function getSniffTestsFixed(): array
    {
        return [
            [
                __DIR__ . '/data/CamelCapsFunctionName.php',
                ['strict' => false],
            ],
            [
                __DIR__ . '/data/CamelCapsFunctionName.php',
                ['strict' => true],
            ],
        ];
    }

    protected function getSniffTestsDoubleUnderscore(): array
    {
        return [
            [
                __DIR__ . '/data/CamelCapsFunctionNameDoubleUnderscorePrefix.php',
                ['strict' => false],
                12,
                'FunctionDoubleUnderscore',
                'Function name "__prefixedFunction" is invalid; only PHP magic functions should be prefixed with a double underscore',
            ],
            [
                __DIR__ . '/data/CamelCapsFunctionNameDoubleUnderscorePrefix.php',
                ['strict' => true],
                12,
                'FunctionDoubleUnderscore',
                'Function name "__prefixedFunction" is invalid; only PHP magic functions should be prefixed with a double underscore',
            ],
            [
                __DIR__ . '/data/CamelCapsFunctionNameDoubleUnderscorePrefix.php',
                ['strict' => false],
                19,
                'MethodDoubleUnderscore',
                'Method name "Foo::__magicPrefix" is invalid; only PHP magic methods should be prefixed with a double underscore',
            ],
            [
                __DIR__ . '/data/CamelCapsFunctionNameDoubleUnderscorePrefix.php',
                ['strict' => true],
                19,
                'MethodDoubleUnderscore',
                'Method name "Foo::__magicPrefix" is invalid; only PHP magic methods should be prefixed with a double underscore',
            ],
        ];
    }

    protected function getSniffTestsVisibility(): array
    {
        return [
            [
                __DIR__ . '/data/CamelCapsFunctionNameUnderscoreVisibility.php',
                ['strict' => false],
                14,
                'MethodUnderscoreVisibility',
                'Method name "Foo::_privateMethod" is invalid; use visibility modifiers instead of prefixing with underscores',
            ],
            [
                __DIR__ . '/data/CamelCapsFunctionNameUnderscoreVisibility.php',
                ['strict' => true],
                14,
                'MethodUnderscoreVisibility',
                'Method name "Foo::_privateMethod" is invalid; use visibility modifiers instead of prefixing with underscores',
            ],
        ];
    }

    protected function getSniffTestsKebabCase(): array
    {
        return [
            [
                __DIR__ . '/data/CamelCapsFunctionNameKebabCase.php',
                ['strict' => false],
                12,
                'NotCamelCaps',
                'Function name "kebab_case_function" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsFunctionNameKebabCase.php',
                ['strict' => true],
                12,
                'NotCamelCaps',
                'Function name "kebab_case_function" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsFunctionNameKebabCase.php',
                ['strict' => false],
                19,
                'NotCamelCaps',
                'Method name "Foo::kebab_case_method" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsFunctionNameKebabCase.php',
                ['strict' => true],
                19,
                'NotCamelCaps',
                'Method name "Foo::kebab_case_method" is not in camel caps format',
            ],
        ];
    }

    protected function getSniffTestsDoubleUppercase(): array
    {
        return [
            [
                __DIR__ . '/data/CamelCapsFunctionNameDoubleUppercase.php',
                ['strict' => false],
                12,
            ],
            [
                __DIR__ . '/data/CamelCapsFunctionNameDoubleUppercase.php',
                ['strict' => true],
                12,
                'NotCamelCaps',
                'Function name "AValidUppercaseFunction" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsFunctionNameDoubleUppercase.php',
                ['strict' => false],
                17,
            ],
            [
                __DIR__ . '/data/CamelCapsFunctionNameDoubleUppercase.php',
                ['strict' => true],
                17,
                'NotCamelCaps',
                'Function name "isThisAValidUppercaseFunction" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsFunctionNameDoubleUppercase.php',
                ['strict' => false],
                24,
            ],
            [
                __DIR__ . '/data/CamelCapsFunctionNameDoubleUppercase.php',
                ['strict' => true],
                24,
                'ScopeNotCamelCaps',
                'Public method name "Foo::AValidUppercaseMethod" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsFunctionNameDoubleUppercase.php',
                ['strict' => false],
                29,
            ],
            [
                __DIR__ . '/data/CamelCapsFunctionNameDoubleUppercase.php',
                ['strict' => true],
                29,
                'ScopeNotCamelCaps',
                'Public method name "Foo::isThisAValidUppercaseMethod" is not in camel caps format',
            ],
        ];
    }
}
