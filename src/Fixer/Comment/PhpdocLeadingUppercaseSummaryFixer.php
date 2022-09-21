<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/easy-coding-standard-config
 */

declare(strict_types=1);

namespace Jgut\ECS\Fixer\Fixer\Comment;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\DocBlock\DocBlock;
use PhpCsFixer\DocBlock\ShortDescription;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class PhpdocLeadingUppercaseSummaryFixer extends AbstractFixer implements DocumentedRuleInterface
{
    /** @see https://regex101.com/r/ZOsFBN/1 */
    private const LINE_DOCBLOCK_REGEX = '#^(?<lead>(?: *\/\*{2}) *)(?<comment>[^\n]+(?!\*\/))(?<tail> *\*\/)$#u';

    /** @see https://regex101.com/r/1zjSz2/1 */
    private const DOCBLOCK_DESCRIPTION_REGEX = '#^(?<lead>(?: *\/?\*) *)(?<comment>.+)$#us';

    private const ERROR_MESSAGE = 'Docblock summary must start with an uppercase letter.';
    private const PRIORITY = 27;

    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(self::ERROR_MESSAGE, []);
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(self::ERROR_MESSAGE, []);
    }

    public function isRisky(): bool
    {
        return false;
    }

    public function getPriority(): int
    {
        return self::PRIORITY;
    }

    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isTokenKindFound(\T_DOC_COMMENT);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function applyFix(SplFileInfo $file, Tokens $tokens): void
    {
        for ($index = $tokens->count() - 1; $index > 0; --$index) {
            /** @var Token $token */
            $token = $tokens[$index];
            if (!$token->isGivenKind([\T_DOC_COMMENT])) {
                continue;
            }

            $modifiedContent = $this->applyFixerToDocBlock($token);

            if ($modifiedContent === $token->getContent()) {
                continue;
            }

            $tokens->offsetSet($index, new Token([(int) $token->getId(), $modifiedContent]));
        }
    }

    protected function applyFixerToDocBlock(Token $commentToken): string
    {
        $originalContent = $commentToken->getContent();
        $docBlock = new DocBlock($originalContent);

        $end = (new ShortDescription($docBlock))->getEnd();
        if ($end === null) {
            if (preg_match(self::LINE_DOCBLOCK_REGEX, $originalContent, $matches) !== 1) {
                return $originalContent;
            }

            return $matches['lead'] . ucfirst($matches['comment']) . $matches['tail'];
        }

        $line = $docBlock->getLine($end);
        if ($line === null) {
            return $originalContent;
        }

        $commentContent = $line->getContent();
        if (preg_match(self::DOCBLOCK_DESCRIPTION_REGEX, $commentContent, $matches) !== 1) {
            return $originalContent;
        }

        $line->setContent($matches['lead'] . ucfirst($matches['comment']));

        return $docBlock->getContent();
    }
}
