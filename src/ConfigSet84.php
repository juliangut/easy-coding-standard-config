<?php

/*
 * (c) 2021-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

namespace Jgut\ECS\Config;

class ConfigSet84 extends ConfigSet82
{
    protected function getRequiredPhpVersion(): string
    {
        return '8.4.0';
    }
}
