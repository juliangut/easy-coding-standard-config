<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

namespace Jgut\ECS\Fixer\Fixer\LanguageConstruct;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\Fixer\ConfigurableFixerInterface;
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolverInterface;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;
use Symplify\RuleDocGenerator\Contract\ConfigurableRuleInterface;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Symplify\SymplifyKernel\Exception\ShouldNotHappenException;

class FloatLeadingZeroFixer extends AbstractFixer implements
    ConfigurableRuleInterface,
    ConfigurableFixerInterface,
    DocumentedRuleInterface
{
    public const LEADING_ZERO = 'leading_zero';
    private const ERROR_MESSAGE = 'Add/remove leading zero on float values.';
    private const PRIORITY = -1;

    protected $configuration = [];

    /**
     * Should a leading zero exist.
     */
    public bool $leadingZero = true;

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(self::ERROR_MESSAGE, []);
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            self::ERROR_MESSAGE,
            [
                new ConfiguredCodeSample(
                    '$floatVal = .5;',
                    '$floatVal = 0.5;',
                    [self::LEADING_ZERO => true],
                ),
                new ConfiguredCodeSample(
                    '$floatVal = 0.5;',
                    '$floatVal = .5;',
                    [self::LEADING_ZERO => false],
                ),
            ],
        );
    }

    public function isRisky(): bool
    {
        return false;
    }

    public function getPriority(): int
    {
        return self::PRIORITY;
    }

    public function configure(array $configuration): void
    {
        $this->leadingZero = (bool) ($configuration[self::LEADING_ZERO] ?? true);
    }

    /**
     * @throws ShouldNotHappenException
     */
    public function getConfigurationDefinition(): FixerConfigurationResolverInterface
    {
        throw new ShouldNotHappenException();
    }

    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isTokenKindFound(\T_DNUMBER);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function applyFix(SplFileInfo $file, Tokens $tokens): void
    {
        /** @var Token $token */
        foreach ($tokens as $index => $token) {
            if (!$token->isGivenKind([\T_DNUMBER])) {
                continue;
            }

            $value = $token->getContent();

            if ($this->leadingZero && $value[0] === '.') {
                $tokens->offsetSet($index, new Token([(int) $token->getId(), '0' . $value]));
            } elseif (!$this->leadingZero && preg_match('/^0\./', $value) === 1) {
                $tokens->offsetSet($index, new Token([(int) $token->getId(), mb_substr($value, 1)]));
            }
        }
    }
}
