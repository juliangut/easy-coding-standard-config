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
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class LeadingUppercaseCommentFixer extends AbstractFixer implements DocumentedRuleInterface
{
    /** @see https://regex101.com/r/U0wFG2/1 */
    private const LINE_COMMENT_REGEX = '#^(?<lead>(?:\/\/|\#(?!\[)) *)(?<comment>.+)#u';

    /** @see https://regex101.com/r/j1TWOt/1 */
    private const BLOCK_COMMENT_REGEX = '#^(?<lead>\/\* *\n?(?: *\** *)?)(?<comment>.+(?!\*\/))(?<tail>\n? *\*\/)$#us';

    private const ERROR_MESSAGE = 'Comments must start with an uppercase letter.';
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
        return $tokens->isTokenKindFound(\T_COMMENT);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function applyFix(SplFileInfo $file, Tokens $tokens): void
    {
        for ($index = $tokens->count() - 1; $index > 0; --$index) {
            /** @var Token $token */
            $token = $tokens[$index];
            if (!$token->isGivenKind([\T_COMMENT])) {
                continue;
            }

            $modifiedContent = $this->applyFixerToComment($token);

            if ($modifiedContent === $token->getContent()) {
                continue;
            }

            $tokens->offsetSet($index, new Token([(int) $token->getId(), $modifiedContent]));
        }
    }

    protected function applyFixerToComment(Token $commentToken): string
    {
        $originalContent = $commentToken->getContent();

        if (preg_match(self::BLOCK_COMMENT_REGEX, $originalContent, $matches) === 1) {
            return $matches['lead'] . ucfirst($matches['comment']) . $matches['tail'];
        }

        if (preg_match(self::LINE_COMMENT_REGEX, $originalContent, $matches) === 1) {
            return $matches['lead'] . ucfirst($matches['comment']);
        }

        return $originalContent;
    }
}
