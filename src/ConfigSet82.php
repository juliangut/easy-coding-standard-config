<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

namespace Jgut\ECS\Fixer;

/**
 * @phpstan-type PhpCsFixerRuleList array<class-string<FixerInterface>, array<string, mixed>|bool>
 * @phpstan-type PhpCodeSnifferRuleList array<class-string<Sniff>, array<string, mixed>|bool>
 */
class ConfigSet82 extends ConfigSet81
{
    protected function getRequiredPhpVersion(): string
    {
        return '8.2.0';
    }
}
