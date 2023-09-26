<?php

/*
 * (c) 2021-2023 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

use Jgut\ECS\Config\ConfigSet80;
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

    (new ConfigSet80())
        ->setHeader($header)
        ->configure($ecsConfig);
};
