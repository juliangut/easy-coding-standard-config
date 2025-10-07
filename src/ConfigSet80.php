<?php

/*
 * (c) 2021-2025 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

namespace Jgut\ECS\Config;

use PhpCsFixer\Fixer\Basic\CurlyBracesPositionFixer;
use PhpCsFixer\Fixer\Casing\NativeFunctionTypeDeclarationCasingFixer;

/**
 * @phpstan-import-type PhpCsFixerRuleList from AbstractConfigSet
 */
class ConfigSet80 extends AbstractConfigSet
{
    protected function getRequiredPhpVersion(): string
    {
        return '8.0.0';
    }

    protected function getRules(): array
    {
        return array_merge(
            parent::getRules(),
            $this->getPhpCsFixerRules(),
        );
    }

    /**
     * @return PhpCsFixerRuleList
     */
    private function getPhpCsFixerRules(): array
    {
        return [
            CurlyBracesPositionFixer::class => true,
            NativeFunctionTypeDeclarationCasingFixer::class => true,
        ];
    }
}
