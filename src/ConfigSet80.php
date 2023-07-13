<?php

/*
 * (c) 2021-2023 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

namespace Jgut\ECS\Config;

class ConfigSet80 extends AbstractConfigSet
{
    protected function getRequiredPhpVersion(): string
    {
        return '8.0.0';
    }
}
