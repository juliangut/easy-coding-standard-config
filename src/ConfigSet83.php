<?php

/*
 * (c) 2021-2025 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

namespace Jgut\ECS\Config;

use PhpCsFixerCustomFixers\Fixer\TypedClassConstantFixer;

/**
 * @phpstan-import-type PhpCsFixerRuleList from AbstractConfigSet
 */
class ConfigSet83 extends ConfigSet82
{
    protected function getRequiredPhpVersion(): string
    {
        return '8.3.0';
    }

    protected function getRules(): array
    {
        return array_merge(
            parent::getRules(),
            $this->getKubawerlosFixerRules(),
        );
    }

    /**
     * @return PhpCsFixerRuleList
     */
    protected function getKubawerlosFixerRules(): array
    {
        return [
            TypedClassConstantFixer::class => true,
        ];
    }
}
