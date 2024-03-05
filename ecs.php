<?php

/*
 * (c) 2021-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

use Jgut\ECS\Config\ConfigSet80;
use PhpCsFixer\Fixer\Phpdoc\PhpdocListTypeFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

$configSet = (new ConfigSet80())
    ->setHeader(<<<'HEADER'
    (c) 2021-{{year}} Julián Gutiérrez <juliangut@gmail.com>

    @license BSD-3-Clause
    @link https://github.com/juliangut/easy-coding-standard-config
    HEADER);
$paths = [
    __FILE__,
    __DIR__ . '/src',
];
$skips = [
    PhpdocListTypeFixer::class => [
        __DIR__ . '/src/AbstractConfigSet.php',
    ],
];

if (!method_exists(ECSConfig::class, 'configure')) {
    return static function (ECSConfig $ecsConfig) use ($configSet, $paths, $skips): void {
        $ecsConfig->paths($paths);
        $configSet->setAdditionalSkips($skips);

        $configSet->configure($ecsConfig);
    };
}

return $configSet
    ->configureBuilder()
    ->withSkip($skips)
    ->withPaths($paths);
