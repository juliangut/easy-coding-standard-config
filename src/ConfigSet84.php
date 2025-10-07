<?php

/*
 * (c) 2021-2025 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

namespace Jgut\ECS\Config;

use PhpCsFixer\Fixer\Operator\NewExpressionParenthesesFixer;
use PhpCsFixerCustomFixers\Fixer\NoUselessWriteVisibilityFixer;

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
        );
    }

    /**
     * @return PhpCsFixerRuleList
     */
    private function getPhpCsFixerRules(): array
    {
        return [
            NewExpressionParenthesesFixer::class => true,
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
}
