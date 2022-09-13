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

final class CamelCapsVariableNameSniffTest extends AbstractSniffTestCase
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
            $this->getSniffTestsVisibility(),
            $this->getSniffTestsKebabCase(),
            $this->getSniffTestsDoubleUppercase(),
        );
    }

    protected function getSniffTestsFixed(): array
    {
        return [
            [
                __DIR__ . '/data/CamelCapsVariableName.php',
                ['strict' => false],
            ],
            [
                __DIR__ . '/data/CamelCapsVariableName.php',
                ['strict' => true],
            ],
        ];
    }

    protected function getSniffTestsVisibility(): array
    {
        return [
            [
                __DIR__ . '/data/CamelCapsVariableNameUnderscoreVisibility.php',
                ['strict' => false],
                14,
                'PropertyUnderscoreVisibility',
                'Property "_privateProperty" is invalid; use visibility modifiers instead of prefixing with underscores',
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameUnderscoreVisibility.php',
                ['strict' => true],
                14,
                'PropertyUnderscoreVisibility',
                'Property "_privateProperty" is invalid; use visibility modifiers instead of prefixing with underscores',
            ],
        ];
    }

    protected function getSniffTestsKebabCase(): array
    {
        return [
            [
                __DIR__ . '/data/CamelCapsVariableNameKebabCase.php',
                ['strict' => false],
                12,
                'NotCamelCaps',
                'Variable "kebab_case_variable" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameKebabCase.php',
                ['strict' => true],
                12,
                'NotCamelCaps',
                'Variable "kebab_case_variable" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameKebabCase.php',
                ['strict' => false],
                14,
                'StringNotCamelCaps',
                'Variable "kebab_case_variable" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameKebabCase.php',
                ['strict' => true],
                14,
                'StringNotCamelCaps',
                'Variable "kebab_case_variable" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameKebabCase.php',
                ['strict' => false],
                18,
                'ScopeNotCamelCaps',
                'Private property "kebab_case_property" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameKebabCase.php',
                ['strict' => true],
                18,
                'ScopeNotCamelCaps',
                'Private property "kebab_case_property" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameKebabCase.php',
                ['strict' => false],
                22,
                'NotCamelCaps',
                'Variable "kebab_case_variable" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameKebabCase.php',
                ['strict' => true],
                22,
                'NotCamelCaps',
                'Variable "kebab_case_variable" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameKebabCase.php',
                ['strict' => false],
                24,
                'StringNotCamelCaps',
                'Variable "kebab_case_variable" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameKebabCase.php',
                ['strict' => true],
                24,
                'StringNotCamelCaps',
                'Variable "kebab_case_variable" is not in camel caps format',
            ],
        ];
    }

    protected function getSniffTestsDoubleUppercase(): array
    {
        return [
            [
                __DIR__ . '/data/CamelCapsVariableNameDoubleUppercase.php',
                ['strict' => false],
                12,
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameDoubleUppercase.php',
                ['strict' => true],
                12,
                'NotCamelCaps',
                'Variable "AValidUppercaseVariable" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameDoubleUppercase.php',
                ['strict' => false],
                14,
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameDoubleUppercase.php',
                ['strict' => true],
                14,
                'StringNotCamelCaps',
                'Variable "AValidUppercaseVariable" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameDoubleUppercase.php',
                ['strict' => false],
                16,
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameDoubleUppercase.php',
                ['strict' => true],
                16,
                'NotCamelCaps',
                'Variable "isThisAValidUppercaseVariable" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameDoubleUppercase.php',
                ['strict' => false],
                22,
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameDoubleUppercase.php',
                ['strict' => true],
                22,
                'ScopeNotCamelCaps',
                'Private property "AValidUppercaseProperty" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameDoubleUppercase.php',
                ['strict' => false],
                24,
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameDoubleUppercase.php',
                ['strict' => true],
                24,
                'ScopeNotCamelCaps',
                'Private property "isThisAValidUppercaseProperty" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameDoubleUppercase.php',
                ['strict' => false],
                28,
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameDoubleUppercase.php',
                ['strict' => true],
                28,
                'NotCamelCaps',
                'Variable "AValidUppercaseVariable" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameDoubleUppercase.php',
                ['strict' => false],
                30,
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameDoubleUppercase.php',
                ['strict' => true],
                30,
                'StringNotCamelCaps',
                'Variable "AValidUppercaseVariable" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameDoubleUppercase.php',
                ['strict' => false],
                32,
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameDoubleUppercase.php',
                ['strict' => true],
                32,
                'NotCamelCaps',
                'Variable "isThisAValidUppercaseVariable" is not in camel caps format',
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameDoubleUppercase.php',
                ['strict' => false],
                34,
            ],
            [
                __DIR__ . '/data/CamelCapsVariableNameDoubleUppercase.php',
                ['strict' => true],
                34,
                'StringNotCamelCaps',
                'Variable "isThisAValidUppercaseVariable" is not in camel caps format',
            ],
        ];
    }
}
