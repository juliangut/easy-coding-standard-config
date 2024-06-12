<?php

/*
 * (c) 2021-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

namespace Jgut\ECS\Config;

use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\RequireExplicitBooleanOperatorPrecedenceSniff;

class ConfigSet82 extends ConfigSet81
{
    protected function getRequiredPhpVersion(): string
    {
        return '8.2.0';
    }

    protected function getRules(): array
    {
        return array_merge(
            parent::getRules(),
            $this->getPhpCodeSnifferRules(),
        );
    }

    /**
     * @return PhpCodeSnifferRuleList
     */
    protected function getPhpCodeSnifferRules(): array
    {
        return [
            RequireExplicitBooleanOperatorPrecedenceSniff::class => true,
        ];
    }
}
