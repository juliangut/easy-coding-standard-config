<?php

/*
 * (c) 2021-2026 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

namespace Jgut\ECS\Config;

use PhpCsFixer\Fixer\Operator\NewExpressionParenthesesFixer;
use PhpCsFixerCustomFixers\Fixer\NoUselessWriteVisibilityFixer;
use Symplify\CodingStandard\Fixer\Commenting\AddMissingParamNameFixer;
use Symplify\CodingStandard\Fixer\Commenting\AddMissingVarNameFixer;
use Symplify\CodingStandard\Fixer\Commenting\DoubleAsteriskInlineVarFixer;
use Symplify\CodingStandard\Fixer\Commenting\FixParamNameTypoFixer;
use Symplify\CodingStandard\Fixer\Commenting\RemoveDeadParamFixer;
use Symplify\CodingStandard\Fixer\Commenting\RemoveParamNameReferenceFixer;
use Symplify\CodingStandard\Fixer\Commenting\RemoveSuperfluousReturnNameFixer;
use Symplify\CodingStandard\Fixer\Commenting\RemoveSuperfluousVarNameFixer;
use Symplify\CodingStandard\Fixer\Commenting\SingleLineInlineVarDocBlockFixer;
use Symplify\CodingStandard\Fixer\Commenting\SwitchedTypeAndNameFixer;

/**
 * @phpstan-import-type PhpCsFixerRuleList from AbstractConfigSet
 */
class ConfigSet84 extends ConfigSet82
{
    protected function getRequiredPhpVersion(): string
    {
        return '8.4.0';
    }

    protected function getRules(): array
    {
        return array_merge(
            parent::getRules(),
            $this->getPhpCsFixerRules(),
            $this->getKubawerlosFixerRules(),
            $this->getSymplifyFixerRules(),
        );
    }

    /**
     * NewExpressionParenthesesFixer is left out on purpose: "new A()->method()" only parses on PHP >= 8.4,
     * breaking projects that run their checks over a version matrix.
     *
     * @return PhpCsFixerRuleList
     */
    private function getPhpCsFixerRules(): array
    {
        return [
            // NewExpressionParenthesesFixer::class => true,
        ];
    }

    /**
     * @return PhpCsFixerRuleList
     */
    protected function getKubawerlosFixerRules(): array
    {
        return [
            NoUselessWriteVisibilityFixer::class => true,
        ];
    }

    /**
     * @return PhpCsFixerRuleList
     */
    protected function getSymplifyFixerRules(): array
    {
        if (!$this->isMinSymplifyVersion('13.1')) {
            return [];
        }

        return [
            'Symplify\CodingStandard\Fixer\Commenting\ParamReturnAndVarTagMalformsFixer' => false,
            AddMissingParamNameFixer::class => true,
            AddMissingVarNameFixer::class => true,
            DoubleAsteriskInlineVarFixer::class => true,
            FixParamNameTypoFixer::class => true,
            RemoveDeadParamFixer::class => true,
            RemoveParamNameReferenceFixer::class => true,
            RemoveSuperfluousReturnNameFixer::class => true,
            RemoveSuperfluousVarNameFixer::class => true,
            SingleLineInlineVarDocBlockFixer::class => true,
            SwitchedTypeAndNameFixer::class => true,
        ];
    }
}
