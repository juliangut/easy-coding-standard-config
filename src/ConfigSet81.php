<?php

/*
 * (c) 2021-2023 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

namespace Jgut\ECS\Config;

use PhpCsFixer\Fixer\Basic\OctalNotationFixer;
use PhpCsFixer\Fixer\ClassNotation\PhpdocReadonlyClassCommentToKeywordFixer;
use SlevomatCodingStandard\Sniffs\Classes\BackedEnumTypeSpacingSniff;
use SlevomatCodingStandard\Sniffs\Classes\EnumCaseSpacingSniff;

class ConfigSet81 extends AbstractConfigSet
{
    protected function getRequiredPhpVersion(): string
    {
        return '8.1.0';
    }

    protected function getRules(): array
    {
        return array_merge(
            parent::getRules(),
            $this->getPhpCsFixerRules(),
            $this->getSlevomatSnifferRules(),
        );
    }

    /**
     * @return PhpCsFixerRuleList
     */
    private function getPhpCsFixerRules(): array
    {
        return [
            OctalNotationFixer::class => true,
            PhpdocReadonlyClassCommentToKeywordFixer::class => true,
        ];
    }

    /**
     * @return PhpCodeSnifferRuleList
     */
    private function getSlevomatSnifferRules(): array
    {
        return [
            BackedEnumTypeSpacingSniff::class => [
                'spacesCountBeforeColon' => 0,
                'spacesCountBeforeType' => 1,
            ],
            EnumCaseSpacingSniff::class => [
                'minLinesCountBeforeWithComment' => 1,
                'maxLinesCountBeforeWithComment' => 1,
                'minLinesCountBeforeWithoutComment' => 1,
                'maxLinesCountBeforeWithoutComment' => 1,
            ],
        ];
    }
}
