<?php

/*
 * (c) 2021-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

use Jgut\ECS\Config\ConfigSet80;

$header = <<<'HEADER'
(c) 2021-{{year}} Julián Gutiérrez <juliangut@gmail.com>

@license BSD-3-Clause
@link https://github.com/juliangut/easy-coding-standard-config
HEADER;

return (new ConfigSet80())
    ->setHeader($header)
    ->configureBuilder()
    ->withPaths([
        __FILE__,
        __DIR__ . '/src',
    ]);
