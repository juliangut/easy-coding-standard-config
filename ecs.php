<?php

/*
 * (c) 2021-2023 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

use Jgut\ECS\Config\ConfigSet74;
use Jgut\ECS\Config\ConfigSet80;
use Jgut\ECS\Config\ConfigSet81;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

$header = <<<'HEADER'
(c) 2021-{{year}} Julián Gutiérrez <juliangut@gmail.com>

@license BSD-3-Clause
@link https://github.com/juliangut/easy-coding-standard-config
HEADER;

return static function (ECSConfig $ecsConfig) use ($header): void {
    $ecsConfig->paths([
        __FILE__,
        __DIR__ . '/src',
    ]);

    if (\PHP_VERSION_ID >= 80_100) {
        $configSet = new ConfigSet81();
    } elseif (\PHP_VERSION_ID >= 80_000) {
        $configSet = new ConfigSet80();
    } else {
        $configSet = new ConfigSet74();
    }

    $configSet
        ->setHeader($header)
        ->setAdditionalRules([
            TrailingCommaInMultilineFixer::class => [ // Temporal while supporting PHP 7.4
                'elements' => ['arrays', 'arguments'],
                'after_heredoc' => true,
            ],
        ])
        ->configure($ecsConfig);
};
