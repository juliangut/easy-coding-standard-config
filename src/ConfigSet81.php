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
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use SlevomatCodingStandard\Sniffs\Classes\BackedEnumTypeSpacingSniff;
use SlevomatCodingStandard\Sniffs\Classes\EnumCaseSpacingSniff;

/**
 * @phpstan-import-type PhpCsFixerRuleList from AbstractConfigSet
 * @phpstan-import-type PhpCodeSnifferRuleList from AbstractConfigSet
 */
class ConfigSet81 extends ConfigSet80
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
        $rules = [];

        if ($this->isMinPhpCsFixerVersion('3.2')) {
            $rules[OctalNotationFixer::class] = true;
        }

        if ($this->isMinPhpCsFixerVersion('3.7')) {
            $rules[ClassAttributesSeparationFixer::class] = [
                'elements' => [
                    'trait_import' => 'none',
                    'const' => 'none',
                    'property' => 'one',
                    'method' => 'one',
                    'case' => 'one',
                ],
            ];
        }

        return $rules;
    }

    /**
     * @return PhpCodeSnifferRuleList
     */
    private function getSlevomatSnifferRules(): array
    {
        $rules = [
            BackedEnumTypeSpacingSniff::class => [
                'spacesCountBeforeColon' => 0,
                'spacesCountBeforeType' => 1,
            ],
        ];

        if ($this->isMinSlevomatVersion('8.9')) {
            $rules[EnumCaseSpacingSniff::class] = [
                'minLinesCountBeforeWithComment' => 1,
                'maxLinesCountBeforeWithComment' => 1,
                'minLinesCountBeforeWithoutComment' => 1,
                'maxLinesCountBeforeWithoutComment' => 1,
            ];
        }

        return $rules;
    }
}
