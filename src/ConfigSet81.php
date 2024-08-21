<?php

/*
 * (c) 2021-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

namespace Jgut\ECS\Config;

use PhpCsFixer\Fixer\Basic\BracesPositionFixer;
use PhpCsFixer\Fixer\Basic\OctalNotationFixer;
use PhpCsFixer\Fixer\Casing\NativeTypeDeclarationCasingFixer;
use PhpCsFixer\Fixer\ClassNotation\PhpdocReadonlyClassCommentToKeywordFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocParamOrderFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitAttributesFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDataProviderNameFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDataProviderReturnTypeFixer;
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
        $rules = [
            BracesPositionFixer::class => true,
            NativeTypeDeclarationCasingFixer::class => true,
            OctalNotationFixer::class => true,
            PhpdocParamOrderFixer::class => true,
            PhpdocReadonlyClassCommentToKeywordFixer::class => true,
        ];

        if ($this->phpUnit) {
            $rules = array_merge(
                $rules,
                [
                    PhpUnitDataProviderNameFixer::class => true,
                    PhpUnitDataProviderReturnTypeFixer::class => true,
                ],
            );

            if ($this->isMinPhpCsFixerVersion('3.54.0')) {
                $rules[PhpUnitAttributesFixer::class] = true;
            }
        }

        return $rules;
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
