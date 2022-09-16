<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

namespace Jgut\ECS\Fixer;

use Composer\InstalledVersions;
use PHP_CodeSniffer\Sniffs\Sniff;
use PhpCsFixer\Fixer\Alias\ModernizeStrposFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\Fixer\LanguageConstruct\GetClassToClassKeywordFixer;
use PhpCsFixer\Fixer\Operator\NoUselessNullsafeOperatorFixer;
use PhpCsFixerCustomFixers\Fixer\MultilinePromotedPropertiesFixer;
use PhpCsFixerCustomFixers\Fixer\PromotedConstructorPropertyFixer;
use PhpCsFixerCustomFixers\Fixer\StringableInterfaceFixer;
use SlevomatCodingStandard\Sniffs\Classes\RequireConstructorPropertyPromotionSniff;
use SlevomatCodingStandard\Sniffs\Exceptions\RequireNonCapturingCatchSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\UnionTypeHintFormatSniff;
use Symplify\CodingStandard\Fixer\Spacing\StandaloneLinePromotedPropertyFixer;

/**
 * @phpstan-type PhpCsFixerRuleList array<class-string<FixerInterface>, array<string, mixed>|bool>
 * @phpstan-type PhpCodeSnifferRuleList array<class-string<Sniff>, array<string, mixed>|bool>
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ConfigSet80 extends ConfigSet74
{
    protected function getRequiredPhpVersion(): string
    {
        return '8.0.0';
    }

    protected function getRules(): array
    {
        return array_merge(
            parent::getRules(),
            $this->getPhpCsFixerRules(),
            $this->getKubawerlosFixerRules(),
            $this->getSymplifyFixerRules(),
            $this->getSlevomatSnifferRules(),
        );
    }

    /**
     * @return PhpCsFixerRuleList
     */
    private function getPhpCsFixerRules(): array
    {
        $rules = [
            TrailingCommaInMultilineFixer::class => [
                'elements' => ['arrays', 'arguments', 'parameters'],
                'after_heredoc' => true,
            ],
        ];

        /** @var string $phpCsFixerVersion */
        $phpCsFixerVersion = preg_replace(
            '/^v/',
            '',
            InstalledVersions::getPrettyVersion('friendsofphp/php-cs-fixer') ?? '',
        );

        if (version_compare($phpCsFixerVersion, '3.2', '>=')) {
            $rules[ModernizeStrposFixer::class] = true;
        }

        if (version_compare($phpCsFixerVersion, '3.5', '>=')) {
            $rules[GetClassToClassKeywordFixer::class] = true;
        }

        if (version_compare($phpCsFixerVersion, '3.9.1', '>=')) {
            $rules[NoUselessNullsafeOperatorFixer::class] = true;
        }

        return $rules;
    }

    /**
     * @return PhpCsFixerRuleList
     */
    private function getKubawerlosFixerRules(): array
    {
        return [
            MultilinePromotedPropertiesFixer::class => true,
            PromotedConstructorPropertyFixer::class => [
                'promote_only_existing_properties' => false,
            ],
            StringableInterfaceFixer::class => true,
        ];
    }

    /**
     * @return PhpCsFixerRuleList
     */
    private function getSymplifyFixerRules(): array
    {
        return [
            StandaloneLinePromotedPropertyFixer::class => true,
        ];
    }

    /**
     * @return PhpCodeSnifferRuleList
     */
    private function getSlevomatSnifferRules(): array
    {
        return [
            RequireConstructorPropertyPromotionSniff::class => true,
            RequireNonCapturingCatchSniff::class => true,
            UnionTypeHintFormatSniff::class => [
                'enable' => true,
                'withSpaces' => 'no',
                'shortNullable' => 'yes',
                'nullPosition' => 'last',
            ],
        ];
    }
}
