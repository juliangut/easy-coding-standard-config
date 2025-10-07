<?php

/*
 * (c) 2021-2025 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

use Jgut\ECS\Config\ConfigSet82;

$configSet = (new ConfigSet82())
    ->setHeader(<<<'HEADER'
    (c) 2021-{{year}} Julián Gutiérrez <juliangut@gmail.com>

    @license BSD-3-Clause
    @link https://github.com/juliangut/easy-coding-standard-config
    HEADER)
    ->enablePhpUnitRules()
    ->enableDoctrineRules();
$paths = [
    __FILE__,
    __DIR__ . '/src',
];

return $configSet
    ->configureBuilder()
    ->withPaths($paths);
