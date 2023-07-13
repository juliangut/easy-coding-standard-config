<?php

/*
 * (c) 2021-2023 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

use Jgut\ECS\Config\ConfigSet80;
use Jgut\ECS\Config\ConfigSet81;
use Jgut\ECS\Config\ConfigSet82;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $header = <<<'HEADER'
    (c) 2021-{{year}} Julián Gutiérrez <juliangut@gmail.com>

    @license BSD-3-Clause
    @link https://github.com/juliangut/easy-coding-standard-config
    HEADER;

    $ecsConfig->paths([
        __FILE__,
        __DIR__ . '/src',
    ]);

    if (\PHP_VERSION_ID >= 80_200) {
        $configSet = new ConfigSet82();
    } elseif (\PHP_VERSION_ID >= 80_100) {
        $configSet = new ConfigSet81();
    } else {
        $configSet = new ConfigSet80();
    }

    $configSet
        ->setHeader($header)
        ->configure($ecsConfig);
};
