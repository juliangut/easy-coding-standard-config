<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

function __prefixedFunction(): void
{
    exit;
}

class Foo
{
    public function __magicPrefix(): void
    {
        exit;
    }
}
