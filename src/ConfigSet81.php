<?php

/*
 * (c) 2021-2023 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

namespace Jgut\ECS\Config;

use Composer\InstalledVersions;
use PhpCsFixer\Fixer\Basic\OctalNotationFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use SlevomatCodingStandard\Sniffs\Classes\BackedEnumTypeSpacingSniff;

/**
 * @phpstan-import-type PhpCsFixerRuleList from AbstractConfigSet
 * @phpstan-import-type PhpCodeSnifferRuleList from AbstractConfigSet
 */
class ConfigSet81 extends ConfigSet80
{
    protected function getRequiredPhpVersion(): string
    {
        return '8.1.0';
    }

    protected function getRules(): array
    {
        return array_merge(
            parent::getRules(),
            $this->getPhpCsFixerRules(),
            $this->getSlevomatSnifferRules(),
        );
    }

    /**
     * @return PhpCsFixerRuleList
     */
    private function getPhpCsFixerRules(): array
    {
        $rules = [];

        /** @var string $phpCsFixerVersion */
        $phpCsFixerVersion = preg_replace(
            '/^v/',
            '',
            InstalledVersions::getPrettyVersion('friendsofphp/php-cs-fixer') ?? '',
        );

        if (version_compare($phpCsFixerVersion, '3.2', '>=')) {
            $rules[OctalNotationFixer::class] = true;
        }

        if (version_compare($phpCsFixerVersion, '3.7', '>=')) {
            $rules[ClassAttributesSeparationFixer::class] = [
                'elements' => [
                    'trait_import' => 'one',
                    'const' => 'none',
                    'property' => 'one',
                    'method' => 'one',
                    'case' => 'one',
                ],
            ];
        }

        return $rules;
    }

    /**
     * @return PhpCodeSnifferRuleList
     */
    private function getSlevomatSnifferRules(): array
    {
        return [
            BackedEnumTypeSpacingSniff::class => [
                'spacesCountBeforeColon' => 0,
                'spacesCountBeforeType' => 1,
            ],
        ];
    }
}
