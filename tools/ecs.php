<?php

/*
 * (c) 2021-2026 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

use Jgut\ECS\Config\ConfigSet82;

$root = __DIR__ . '/..';

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
    $root . '/src',
    $root . '/tests',
];

return $configSet
    ->configureBuilder()
    ->withCache($root . '/tools/.ecs.cache')
    ->withPaths($paths);
