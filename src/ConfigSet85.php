<?php

/*
 * (c) 2021-2026 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

namespace Jgut\ECS\Config;

/**
 * PHP 8.5 deprecations (backtick operator, non-canonical casts, semicolon after case) are already fixed on every
 * config set. ModernSerializationMethodsFixer is left out on purpose: it renames __sleep/__wakeup into
 * __serialize/__unserialize, which return and receive different data, silently breaking serialization.
 */
class ConfigSet85 extends ConfigSet84
{
    protected function getRequiredPhpVersion(): string
    {
        return '8.5.0';
    }
}
