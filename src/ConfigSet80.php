<?php

/*
 * (c) 2021-2023 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

namespace Jgut\ECS\Config;

use PhpCsFixer\Fixer\Alias\ModernizeStrposFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\LanguageConstruct\GetClassToClassKeywordFixer;
use PhpCsFixer\Fixer\Operator\NoUselessNullsafeOperatorFixer;
use PhpCsFixerCustomFixers\Fixer\MultilinePromotedPropertiesFixer;
use PhpCsFixerCustomFixers\Fixer\PromotedConstructorPropertyFixer;
use PhpCsFixerCustomFixers\Fixer\StringableInterfaceFixer;
use SlevomatCodingStandard\Sniffs\Attributes\AttributeAndTargetSpacingSniff;
use SlevomatCodingStandard\Sniffs\Attributes\DisallowAttributesJoiningSniff;
use SlevomatCodingStandard\Sniffs\Attributes\RequireAttributeAfterDocCommentSniff;
use SlevomatCodingStandard\Sniffs\Classes\RequireConstructorPropertyPromotionSniff;
use SlevomatCodingStandard\Sniffs\Exceptions\RequireNonCapturingCatchSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\UnionTypeHintFormatSniff;
use Symplify\CodingStandard\Fixer\Spacing\StandaloneLinePromotedPropertyFixer;

/**
 * @phpstan-import-type PhpCsFixerRuleList from AbstractConfigSet
 * @phpstan-import-type PhpCodeSnifferRuleList from AbstractConfigSet
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

        if ($this->isMinPhpCsFixerVersion('3.2')) {
            $rules[ModernizeStrposFixer::class] = true;
        }

        if ($this->isMinPhpCsFixerVersion('3.5')) {
            $rules[GetClassToClassKeywordFixer::class] = true;
        }

        if ($this->isMinPhpCsFixerVersion('3.9.1')) {
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
        $rules = [
            RequireConstructorPropertyPromotionSniff::class => true,
            RequireNonCapturingCatchSniff::class => true,
            UnionTypeHintFormatSniff::class => [
                'enable' => true,
                'withSpaces' => 'no',
                'shortNullable' => 'yes',
                'nullPosition' => 'last',
            ],
        ];

        if ($this->isMinSlevomatVersion('8.6')) {
            $rules[AttributeAndTargetSpacingSniff::class] = true;
            $rules[DisallowAttributesJoiningSniff::class] = true;
            $rules[RequireAttributeAfterDocCommentSniff::class] = true;
        }

        return $rules;
    }
}
