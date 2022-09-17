<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

namespace Jgut\ECS\Fixer\Tests\Fixer\LanguageConstruct;

use Jgut\ECS\Fixer\Fixer\LanguageConstruct\FloatLeadingZeroFixer;
use Jgut\ECS\Fixer\Tests\Fixer\AbstractFixerTestCase;

class FloatLeadingZeroFixerTest extends AbstractFixerTestCase
{
    /**
     * @dataProvider fixCasesProvider
     *
     * @param array<string, mixed> $config
     */
    public function testFix(string $expected, ?string $input = null, array $config = []): void
    {
        $this->fixer->configure($config);

        $this->doTest($expected, $input);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function fixCasesProvider(): array
    {
        return [
            'base leading zero' => [
                '<?php $floatVariable = 0.1;',
            ],
            'base leading zero with config' => [
                '<?php $floatVariable = 0.1;',
                null,
                [FloatLeadingZeroFixer::LEADING_ZERO => true],
            ],
            'add leading zero' => [
                '<?php $floatVariable = 0.1;',
                '<?php $floatVariable = .1;',
            ],
            'add leading zero with config' => [
                '<?php $floatVariable = 0.1;',
                '<?php $floatVariable = .1;',
                [FloatLeadingZeroFixer::LEADING_ZERO => true],
            ],
            'base non leading zero with config' => [
                '<?php $floatVariable = .1;',
                null,
                [FloatLeadingZeroFixer::LEADING_ZERO => false],
            ],
            'remove leading zero with config' => [
                '<?php $floatVariable = .1;',
                '<?php $floatVariable = 0.1;',
                [FloatLeadingZeroFixer::LEADING_ZERO => false],
            ],
        ];
    }
}
