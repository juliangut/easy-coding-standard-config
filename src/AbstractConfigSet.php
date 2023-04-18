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
use DateTimeImmutable;
use Jgut\PhpCsFixerCustomFixers\Fixer\Comment\LeadingUppercaseCommentFixer;
use Jgut\PhpCsFixerCustomFixers\Fixer\Comment\PhpdocLeadingUppercaseSummaryFixer;
use Jgut\PhpCsFixerCustomFixers\Fixer\LanguageConstruct\FloatLeadingZeroFixer;
use JgutCodingStandard\Sniffs\CodeAnalysis\EmptyStatementSniff;
use JgutCodingStandard\Sniffs\NamingConventions\CamelCapsFunctionNameSniff;
use JgutCodingStandard\Sniffs\NamingConventions\CamelCapsVariableNameSniff;
use PedroTroller\CS\Fixer\CodingStyle\ExceptionsPunctuationFixer;
use PedroTroller\CS\Fixer\CodingStyle\ForbiddenFunctionsFixer;
use PedroTroller\CS\Fixer\CodingStyle\LineBreakBetweenMethodArgumentsFixer;
use PedroTroller\CS\Fixer\Comment\CommentLineToPhpdocBlockFixer;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\ForLoopWithTestFunctionCallSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\JumbledIncrementerSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\UnconditionalIfStatementSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\UnnecessaryFinalModifierSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\UselessOverridingMethodSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Commenting\FixmeSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Commenting\TodoSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\OneObjectStructurePerFileSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Metrics\NestingLevelSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\UpperCaseConstantNameSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\DeprecatedFunctionsSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\DisallowRequestSuperglobalSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\NoSilencedErrorsSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\VersionControl\GitMergeConflictSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Commenting\FunctionCommentThrowTagSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP\CommentedOutCodeSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP\EvalSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Scope\MemberVarScopeSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Scope\StaticThisUsageSniff;
use PhpCsFixer\Fixer\Alias\ArrayPushFixer;
use PhpCsFixer\Fixer\Alias\BacktickToShellExecFixer;
use PhpCsFixer\Fixer\Alias\EregToPregFixer;
use PhpCsFixer\Fixer\Alias\MbStrFunctionsFixer;
use PhpCsFixer\Fixer\Alias\NoAliasFunctionsFixer;
use PhpCsFixer\Fixer\Alias\NoAliasLanguageConstructCallFixer;
use PhpCsFixer\Fixer\Alias\NoMixedEchoPrintFixer;
use PhpCsFixer\Fixer\Alias\PowToExponentiationFixer;
use PhpCsFixer\Fixer\Alias\RandomApiMigrationFixer;
use PhpCsFixer\Fixer\Alias\SetTypeToCastFixer;
use PhpCsFixer\Fixer\ArrayNotation\NormalizeIndexBraceFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoTrailingCommaInSinglelineArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\TrimArraySpacesFixer;
use PhpCsFixer\Fixer\ArrayNotation\WhitespaceAfterCommaInArrayFixer;
use PhpCsFixer\Fixer\Basic\BracesFixer;
use PhpCsFixer\Fixer\Basic\CurlyBracesPositionFixer;
use PhpCsFixer\Fixer\Basic\NoMultipleStatementsPerLineFixer;
use PhpCsFixer\Fixer\Basic\NonPrintableCharacterFixer;
use PhpCsFixer\Fixer\Basic\PsrAutoloadingFixer;
use PhpCsFixer\Fixer\Casing\ClassReferenceNameCasingFixer;
use PhpCsFixer\Fixer\Casing\IntegerLiteralCaseFixer;
use PhpCsFixer\Fixer\Casing\MagicConstantCasingFixer;
use PhpCsFixer\Fixer\Casing\MagicMethodCasingFixer;
use PhpCsFixer\Fixer\Casing\NativeFunctionCasingFixer;
use PhpCsFixer\Fixer\Casing\NativeFunctionTypeDeclarationCasingFixer;
use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;
use PhpCsFixer\Fixer\CastNotation\ModernizeTypesCastingFixer;
use PhpCsFixer\Fixer\CastNotation\NoShortBoolCastFixer;
use PhpCsFixer\Fixer\CastNotation\NoUnsetCastFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ClassNotation\NoNullPropertyInitializationFixer;
use PhpCsFixer\Fixer\ClassNotation\NoPhp4ConstructorFixer;
use PhpCsFixer\Fixer\ClassNotation\NoUnneededFinalMethodFixer;
use PhpCsFixer\Fixer\ClassNotation\ProtectedToPrivateFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfAccessorFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfStaticAccessorFixer;
use PhpCsFixer\Fixer\ClassNotation\SingleTraitInsertPerStatementFixer;
use PhpCsFixer\Fixer\ClassUsage\DateTimeImmutableFixer;
use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use PhpCsFixer\Fixer\Comment\MultilineCommentOpeningClosingFixer;
use PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer;
use PhpCsFixer\Fixer\Comment\SingleLineCommentSpacingFixer;
use PhpCsFixer\Fixer\Comment\SingleLineCommentStyleFixer;
use PhpCsFixer\Fixer\ConstantNotation\NativeConstantInvocationFixer;
use PhpCsFixer\Fixer\ControlStructure\ControlStructureBracesFixer;
use PhpCsFixer\Fixer\ControlStructure\ControlStructureContinuationPositionFixer;
use PhpCsFixer\Fixer\ControlStructure\EmptyLoopBodyFixer;
use PhpCsFixer\Fixer\ControlStructure\IncludeFixer;
use PhpCsFixer\Fixer\ControlStructure\NoAlternativeSyntaxFixer;
use PhpCsFixer\Fixer\ControlStructure\NoSuperfluousElseifFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUnneededControlParenthesesFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUnneededCurlyBracesFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUselessElseFixer;
use PhpCsFixer\Fixer\ControlStructure\SimplifiedIfReturnFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchContinueToBreakFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;
use PhpCsFixer\Fixer\DoctrineAnnotation\DoctrineAnnotationArrayAssignmentFixer;
use PhpCsFixer\Fixer\DoctrineAnnotation\DoctrineAnnotationBracesFixer;
use PhpCsFixer\Fixer\DoctrineAnnotation\DoctrineAnnotationIndentationFixer;
use PhpCsFixer\Fixer\DoctrineAnnotation\DoctrineAnnotationSpacesFixer;
use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\Fixer\FunctionNotation\CombineNestedDirnameFixer;
use PhpCsFixer\Fixer\FunctionNotation\DateTimeCreateFromFormatCallFixer;
use PhpCsFixer\Fixer\FunctionNotation\FopenFlagOrderFixer;
use PhpCsFixer\Fixer\FunctionNotation\FopenFlagsFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionTypehintSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\ImplodeCallFixer;
use PhpCsFixer\Fixer\FunctionNotation\LambdaNotUsedImportFixer;
use PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoTrailingCommaInSinglelineFunctionCallFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoUnreachableDefaultArgumentValueFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoUselessSprintfFixer;
use PhpCsFixer\Fixer\FunctionNotation\NullableTypeDeclarationForDefaultNullValueFixer;
use PhpCsFixer\Fixer\FunctionNotation\PhpdocToParamTypeFixer;
use PhpCsFixer\Fixer\FunctionNotation\PhpdocToPropertyTypeFixer;
use PhpCsFixer\Fixer\FunctionNotation\PhpdocToReturnTypeFixer;
use PhpCsFixer\Fixer\FunctionNotation\RegularCallableCallFixer;
use PhpCsFixer\Fixer\FunctionNotation\StaticLambdaFixer;
use PhpCsFixer\Fixer\FunctionNotation\UseArrowFunctionsFixer;
use PhpCsFixer\Fixer\FunctionNotation\VoidReturnFixer;
use PhpCsFixer\Fixer\Import\FullyQualifiedStrictTypesFixer;
use PhpCsFixer\Fixer\Import\GlobalNamespaceImportFixer;
use PhpCsFixer\Fixer\Import\NoUnneededImportAliasFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\CombineConsecutiveIssetsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\CombineConsecutiveUnsetsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DeclareParenthesesFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DirConstantFixer;
use PhpCsFixer\Fixer\LanguageConstruct\ErrorSuppressionFixer;
use PhpCsFixer\Fixer\LanguageConstruct\ExplicitIndirectVariableFixer;
use PhpCsFixer\Fixer\LanguageConstruct\FunctionToConstantFixer;
use PhpCsFixer\Fixer\LanguageConstruct\IsNullFixer;
use PhpCsFixer\Fixer\LanguageConstruct\NoUnsetOnPropertyFixer;
use PhpCsFixer\Fixer\LanguageConstruct\SingleSpaceAfterConstructFixer;
use PhpCsFixer\Fixer\LanguageConstruct\SingleSpaceAroundConstructFixer;
use PhpCsFixer\Fixer\ListNotation\ListSyntaxFixer;
use PhpCsFixer\Fixer\NamespaceNotation\CleanNamespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\NoLeadingNamespaceWhitespaceFixer;
use PhpCsFixer\Fixer\Naming\NoHomoglyphNamesFixer;
use PhpCsFixer\Fixer\Operator\AssignNullCoalescingToCoalesceEqualFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Operator\IncrementStyleFixer;
use PhpCsFixer\Fixer\Operator\LogicalOperatorsFixer;
use PhpCsFixer\Fixer\Operator\NoSpaceAroundDoubleColonFixer;
use PhpCsFixer\Fixer\Operator\NoUselessConcatOperatorFixer;
use PhpCsFixer\Fixer\Operator\ObjectOperatorWithoutWhitespaceFixer;
use PhpCsFixer\Fixer\Operator\OperatorLinebreakFixer;
use PhpCsFixer\Fixer\Operator\StandardizeIncrementFixer;
use PhpCsFixer\Fixer\Operator\StandardizeNotEqualsFixer;
use PhpCsFixer\Fixer\Operator\TernaryToElvisOperatorFixer;
use PhpCsFixer\Fixer\Operator\TernaryToNullCoalescingFixer;
use PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Phpdoc\AlignMultilineCommentFixer;
use PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocAnnotationRemoveFixer;
use PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocTagRenameFixer;
use PhpCsFixer\Fixer\Phpdoc\NoBlankLinesAfterPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAddMissingParamAnnotationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAlignFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAnnotationWithoutDotFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocIndentFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocInlineTagNormalizerFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocLineSpanFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoAccessFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoAliasTagFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoEmptyReturnFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoPackageFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoUselessInheritdocFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocReturnSelfReferenceFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocScalarFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSeparationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSingleLineVarSpacingFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSummaryFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTagCasingFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTagTypeFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTrimConsecutiveBlankLineSeparationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTrimFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocVarWithoutNameFixer;
use PhpCsFixer\Fixer\PhpTag\EchoTagSyntaxFixer;
use PhpCsFixer\Fixer\PhpTag\LinebreakAfterOpeningTagFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitConstructFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDataProviderStaticFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDedicateAssertFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDedicateAssertInternalTypeFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitExpectationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitInternalClassFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMethodCasingFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMockFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMockShortWillReturnFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitNamespacedFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitNoExpectationAnnotationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitSetUpTearDownVisibilityFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestAnnotationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestCaseStaticMethodCallsFixer;
use PhpCsFixer\Fixer\ReturnNotation\NoUselessReturnFixer;
use PhpCsFixer\Fixer\ReturnNotation\ReturnAssignmentFixer;
use PhpCsFixer\Fixer\ReturnNotation\SimplifiedNullReturnFixer;
use PhpCsFixer\Fixer\Semicolon\MultilineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Semicolon\NoEmptyStatementFixer;
use PhpCsFixer\Fixer\Semicolon\NoSinglelineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Semicolon\SemicolonAfterInstructionFixer;
use PhpCsFixer\Fixer\Semicolon\SpaceAfterSemicolonFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use PhpCsFixer\Fixer\Strict\StrictParamFixer;
use PhpCsFixer\Fixer\StringNotation\EscapeImplicitBackslashesFixer;
use PhpCsFixer\Fixer\StringNotation\ExplicitStringVariableFixer;
use PhpCsFixer\Fixer\StringNotation\HeredocToNowdocFixer;
use PhpCsFixer\Fixer\StringNotation\NoBinaryStringFixer;
use PhpCsFixer\Fixer\StringNotation\NoTrailingWhitespaceInStringFixer;
use PhpCsFixer\Fixer\StringNotation\SimpleToComplexStringVariableFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use PhpCsFixer\Fixer\StringNotation\StringLengthToEmptyFixer;
use PhpCsFixer\Fixer\StringNotation\StringLineEndingFixer;
use PhpCsFixer\Fixer\Whitespace\ArrayIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer;
use PhpCsFixer\Fixer\Whitespace\HeredocIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\MethodChainingIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer;
use PhpCsFixer\Fixer\Whitespace\NoSpacesAroundOffsetFixer;
use PhpCsFixer\Fixer\Whitespace\NoWhitespaceInBlankLineFixer;
use PhpCsFixer\Fixer\Whitespace\StatementIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\TypesSpacesFixer;
use PhpCsFixerCustomFixers\Fixer\CommentSurroundedBySpacesFixer;
use PhpCsFixerCustomFixers\Fixer\ConstructorEmptyBracesFixer;
use PhpCsFixerCustomFixers\Fixer\DataProviderNameFixer;
use PhpCsFixerCustomFixers\Fixer\EmptyFunctionBodyFixer;
use PhpCsFixerCustomFixers\Fixer\IssetToArrayKeyExistsFixer;
use PhpCsFixerCustomFixers\Fixer\NoCommentedOutCodeFixer;
use PhpCsFixerCustomFixers\Fixer\NoDoctrineMigrationsGeneratedCommentFixer;
use PhpCsFixerCustomFixers\Fixer\NoDuplicatedArrayKeyFixer;
use PhpCsFixerCustomFixers\Fixer\NoLeadingSlashInGlobalNamespaceFixer;
use PhpCsFixerCustomFixers\Fixer\NoNullableBooleanTypeFixer;
use PhpCsFixerCustomFixers\Fixer\NoPhpStormGeneratedCommentFixer;
use PhpCsFixerCustomFixers\Fixer\NoSuperfluousConcatenationFixer;
use PhpCsFixerCustomFixers\Fixer\NoTrailingCommaInSinglelineFixer;
use PhpCsFixerCustomFixers\Fixer\NoUselessCommentFixer;
use PhpCsFixerCustomFixers\Fixer\NoUselessDirnameCallFixer;
use PhpCsFixerCustomFixers\Fixer\NoUselessDoctrineRepositoryCommentFixer;
use PhpCsFixerCustomFixers\Fixer\NoUselessParenthesisFixer;
use PhpCsFixerCustomFixers\Fixer\NumericLiteralSeparatorFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocArrayStyleFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocNoSuperfluousParamFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocParamOrderFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocParamTypeFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocSelfAccessorFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocTypesCommaSpacesFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocTypesTrimFixer;
use RuntimeException;
use SlevomatCodingStandard\Sniffs\Arrays\DisallowImplicitArrayCreationSniff;
use SlevomatCodingStandard\Sniffs\Classes\ClassConstantVisibilitySniff;
use SlevomatCodingStandard\Sniffs\Classes\DisallowLateStaticBindingForConstantsSniff;
use SlevomatCodingStandard\Sniffs\Classes\DisallowMultiConstantDefinitionSniff;
use SlevomatCodingStandard\Sniffs\Classes\DisallowMultiPropertyDefinitionSniff;
use SlevomatCodingStandard\Sniffs\Classes\DisallowStringExpressionPropertyFetchSniff;
use SlevomatCodingStandard\Sniffs\Classes\UselessLateStaticBindingSniff;
use SlevomatCodingStandard\Sniffs\Commenting\EmptyCommentSniff;
use SlevomatCodingStandard\Sniffs\Commenting\UselessInheritDocCommentSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\AssignmentInConditionSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowContinueWithoutIntegerOperandInSwitchSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowEmptySniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowTrailingMultiLineTernaryOperatorSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireMultiLineConditionSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireMultiLineTernaryOperatorSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireNullCoalesceEqualOperatorSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireNullCoalesceOperatorSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireShortTernaryOperatorSniff;
use SlevomatCodingStandard\Sniffs\Exceptions\DeadCatchSniff;
use SlevomatCodingStandard\Sniffs\Exceptions\ReferenceThrowableOnlySniff;
use SlevomatCodingStandard\Sniffs\Functions\RequireMultiLineCallSniff;
use SlevomatCodingStandard\Sniffs\Functions\UnusedInheritedVariablePassedToClosureSniff;
use SlevomatCodingStandard\Sniffs\Functions\UselessParameterDefaultValueSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\UselessAliasSniff;
use SlevomatCodingStandard\Sniffs\Operators\RequireCombinedAssignmentOperatorSniff;
use SlevomatCodingStandard\Sniffs\Operators\RequireOnlyStandaloneIncrementAndDecrementOperatorsSniff;
use SlevomatCodingStandard\Sniffs\PHP\ReferenceSpacingSniff;
use SlevomatCodingStandard\Sniffs\PHP\UselessParenthesesSniff;
use SlevomatCodingStandard\Sniffs\PHP\UselessSemicolonSniff;
use SlevomatCodingStandard\Sniffs\Strings\DisallowVariableParsingSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ParameterTypeHintSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\PropertyTypeHintSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ReturnTypeHintSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\UselessConstantTypeHintSniff;
use SlevomatCodingStandard\Sniffs\Variables\DisallowVariableVariableSniff;
use Symplify\CodingStandard\Fixer\ArrayNotation\StandaloneLineInMultilineArrayFixer;
use Symplify\CodingStandard\Fixer\Commenting\ParamReturnAndVarTagMalformsFixer;
use Symplify\CodingStandard\Fixer\Commenting\RemoveUselessDefaultCommentFixer;
use Symplify\CodingStandard\Fixer\LineLength\DocBlockLineLengthFixer;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\CodingStandard\Fixer\Spacing\MethodChainingNewlineFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

/**
 * @phpstan-type PhpCsFixerRuleList array<class-string<FixerInterface>, array<string, mixed>|bool>
 * @phpstan-type PhpCodeSnifferRuleList array<class-string<Sniff>, array<string, mixed>|bool>
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
abstract class AbstractConfigSet
{
    private ?string $header = null;

    private bool $doctrine = false;

    private bool $phpUnit = false;

    private bool $typeInfer = false;

    /**
     * @var array<string|class-string<Sniff|FixerInterface>, array<string, mixed>|bool>
     */
    private array $additionalRules = [];

    /**
     * @var array<class-string<Sniff|FixerInterface>>
     */
    private array $additionalSkips = [];

    public function __construct()
    {
        if (version_compare($this->getRequiredPhpVersion(), \PHP_VERSION, '>')) {
            throw new RuntimeException(sprintf(
                'Minimum required PHP version is "%s", current version is "%s".',
                $this->getRequiredPhpVersion(),
                \PHP_VERSION,
            ));
        }
    }

    abstract protected function getRequiredPhpVersion(): string;

    final public function configure(ECSConfig $ecsConfig): self
    {
        $ecsConfig->lineEnding("\n");

        $ecsConfig->sets([SetList::PSR_12]);

        /** @var array<class-string<Sniff|FixerInterface>, bool|array<string, mixed>> $rules */
        $rules = array_merge(
            $this->getRules(),
            $this->additionalRules,
        );
        $header = $this->getHeader();
        if ($header !== null) {
            $rules[HeaderCommentFixer::class] = [
                'header' => $header,
                'comment_type' => 'comment',
                'location' => 'after_open',
                'separate' => 'both',
            ];
        }

        /** @var array<class-string<Sniff>> $reportSniffs */
        $reportSniffs = [];
        /** @var array<class-string<Sniff|FixerInterface>> $skipRules */
        $skipRules = [];

        foreach ($rules as $rule => $config) {
            if (\is_array($config) || $config === true) {
                if ($config === true) {
                    $ecsConfig->rule($rule);
                } else {
                    $ecsConfig->ruleWithConfiguration($rule, $config);
                }

                if (is_a($rule, Sniff::class, true)) {
                    $reportSniffs[] = $rule;
                }
            } else {
                $skipRules[] = $rule;
            }
        }

        $ecsConfig->reportSniffClassWarnings($reportSniffs);

        $skipRules = array_merge(
            $skipRules,
            $this->getSkips(),
            $this->additionalSkips,
        );
        $ecsConfig->skip($skipRules);

        return $this;
    }

    /**
     * @return array<class-string<Sniff|FixerInterface>, array<string, mixed>|bool>
     */
    protected function getRules(): array
    {
        return array_merge(
            $this->getPhpCsFixerRules(),
            $this->getKubawerlosFixerRules(),
            $this->getPedroTrollerFixerRules(),
            $this->getSymplifyFixerRules(),
            $this->getJuliangutFixerRules(),
            $this->getPhpCodeSnifferRules(),
            $this->getSlevomatSnifferRules(),
            $this->getJuliangutSnifferRules(),
        );
    }

    /**
     * @return PhpCsFixerRuleList
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    private function getPhpCsFixerRules(): array
    {
        /** @var PhpCsFixerRuleList $rules */
        $rules = [
            AlignMultilineCommentFixer::class => [
                'comment_type' => 'phpdocs_like',
            ],
            ArrayIndentationFixer::class => true,
            ArrayPushFixer::class => true,
            BacktickToShellExecFixer::class => true,
            BinaryOperatorSpacesFixer::class => [
                'default' => 'single_space',
            ],
            BlankLineBeforeStatementFixer::class => [
                'statements' => ['case', 'continue', 'declare', 'default', 'return', 'throw', 'try'],
            ],
            BracesFixer::class => [
                'allow_single_line_anonymous_class_with_empty_body' => true,
                'allow_single_line_closure' => true,
            ],
            CastSpacesFixer::class => [
                'space' => 'single',
            ],
            ClassAttributesSeparationFixer::class => [
                'elements' => [
                    'trait_import' => 'none',
                    'const' => 'none',
                    'property' => 'one',
                    'method' => 'one',
                ],
            ],
            CleanNamespaceFixer::class => true,
            CombineConsecutiveIssetsFixer::class => true,
            CombineConsecutiveUnsetsFixer::class => true,
            CombineNestedDirnameFixer::class => true,
            ConcatSpaceFixer::class => [
                'spacing' => 'one',
            ],
            DateTimeImmutableFixer::class => true,
            DeclareParenthesesFixer::class => true,
            DeclareStrictTypesFixer::class => true,
            DirConstantFixer::class => true,
            EchoTagSyntaxFixer::class => [
                'format' => 'long',
                'long_function' => 'echo',
                'shorten_simple_statements_only' => true,
            ],
            EmptyLoopBodyFixer::class => [
                'style' => 'braces',
            ],
            EregToPregFixer::class => true,
            ErrorSuppressionFixer::class => [
                'mute_deprecation_error' => false,
                'noise_remaining_usages' => false,
            ],
            EscapeImplicitBackslashesFixer::class => [
                'double_quoted' => true,
                'heredoc_syntax' => true,
                'single_quoted' => false,
            ],
            ExplicitIndirectVariableFixer::class => true,
            ExplicitStringVariableFixer::class => true,
            // FinalClassFixer::class => true,
            // FinalPublicMethodForAbstractClassFixer::class => true,
            FopenFlagOrderFixer::class => true,
            FopenFlagsFixer::class => [
                'b_mode' => true,
            ],
            FullyQualifiedStrictTypesFixer::class => true,
            FunctionToConstantFixer::class => [
                'functions' => ['get_called_class', 'get_class', 'get_class_this', 'php_sapi_name', 'phpversion', 'pi'],
            ],
            FunctionTypehintSpaceFixer::class => true,
            GeneralPhpdocAnnotationRemoveFixer::class => [
                'annotations' => ['access', 'author', 'copyright', 'package', 'subpackage', 'tutorial'],
            ],
            GeneralPhpdocTagRenameFixer::class => [
                'replacements' => [
                    'inheritdoc' => 'inheritDoc',
                    'inheritdocs' => 'inheritDoc',
                ],
            ],
            GlobalNamespaceImportFixer::class => [
                'import_classes' => true,
                'import_functions' => false,
                'import_constants' => false,
            ],
            HeredocIndentationFixer::class => [
                'indentation' => 'same_as_start',
            ],
            HeredocToNowdocFixer::class => true,
            ImplodeCallFixer::class => true,
            IncludeFixer::class => true,
            IncrementStyleFixer::class => [
                'style' => 'pre',
            ],
            IsNullFixer::class => true,
            LambdaNotUsedImportFixer::class => true,
            ListSyntaxFixer::class => [
                'syntax' => 'short',
            ],
            LinebreakAfterOpeningTagFixer::class => true,
            LogicalOperatorsFixer::class => true,
            MagicConstantCasingFixer::class => true,
            MagicMethodCasingFixer::class => true,
            MbStrFunctionsFixer::class => true,
            MethodArgumentSpaceFixer::class => [
                'after_heredoc' => true,
                'keep_multiple_spaces_after_comma' => false,
                'on_multiline' => 'ensure_fully_multiline',
            ],
            MethodChainingIndentationFixer::class => true,
            ModernizeTypesCastingFixer::class => true,
            MultilineCommentOpeningClosingFixer::class => true,
            MultilineWhitespaceBeforeSemicolonsFixer::class => [
                'strategy' => 'no_multi_line',
            ],
            NativeConstantInvocationFixer::class => [
                'exclude' => ['null', 'false', 'true'],
                'fix_built_in' => true,
                'scope' => 'all',
                'strict' => true,
            ],
            NativeFunctionCasingFixer::class => true,
            NativeFunctionInvocationFixer::class => [
                'include' => ['@compiler_optimized'],
                'scope' => 'all',
                'strict' => true,
            ],
            NativeFunctionTypeDeclarationCasingFixer::class => true,
            NoAliasFunctionsFixer::class => [
                'sets' => ['@all'],
            ],
            NoAliasLanguageConstructCallFixer::class => true,
            NoAlternativeSyntaxFixer::class => true,
            NoBinaryStringFixer::class => true,
            NoBlankLinesAfterPhpdocFixer::class => true,
            NoEmptyCommentFixer::class => true,
            NoEmptyPhpdocFixer::class => true,
            NoEmptyStatementFixer::class => true,
            NoExtraBlankLinesFixer::class => [
                'tokens' => [
                    'break',
                    'case',
                    'continue',
                    'curly_brace_block',
                    'default',
                    'extra',
                    'parenthesis_brace_block',
                    'return',
                    'square_brace_block',
                    'switch',
                    'throw',
                ],
            ],
            NoHomoglyphNamesFixer::class => true,
            NoLeadingNamespaceWhitespaceFixer::class => true,
            NoMixedEchoPrintFixer::class => [
                'use' => 'echo',
            ],
            NoNullPropertyInitializationFixer::class => true,
            NoPhp4ConstructorFixer::class => true,
            NoShortBoolCastFixer::class => true,
            NoSinglelineWhitespaceBeforeSemicolonsFixer::class => true,
            NoSpacesAroundOffsetFixer::class => [
                'positions' => ['inside', 'outside'],
            ],
            NoSuperfluousElseifFixer::class => true,
            NoSuperfluousPhpdocTagsFixer::class => [
                'allow_mixed' => false,
                'allow_unused_params' => false,
            ],
            NoTrailingCommaInSinglelineArrayFixer::class => true,
            NoTrailingWhitespaceInStringFixer::class => true,
            NoUnneededControlParenthesesFixer::class => [
                'statements' => ['break', 'clone', 'continue', 'echo_print', 'return', 'switch_case', 'yield'],
            ],
            NoUnneededCurlyBracesFixer::class => [
                'namespaces' => true,
            ],
            NoUnneededFinalMethodFixer::class => [
                'private_methods' => true,
            ],
            NoUnreachableDefaultArgumentValueFixer::class => true,
            NoUnsetCastFixer::class => true,
            NoUnsetOnPropertyFixer::class => true,
            NoUnusedImportsFixer::class => true,
            NoUselessElseFixer::class => true,
            NoUselessReturnFixer::class => true,
            NoUselessSprintfFixer::class => true,
            NoWhitespaceBeforeCommaInArrayFixer::class => [
                'after_heredoc' => true,
            ],
            NoWhitespaceInBlankLineFixer::class => true,
            NonPrintableCharacterFixer::class => [
                'use_escape_sequences_in_strings' => false,
            ],
            NormalizeIndexBraceFixer::class => true,
            NullableTypeDeclarationForDefaultNullValueFixer::class => [
                'use_nullable_type_declaration' => true,
            ],
            ObjectOperatorWithoutWhitespaceFixer::class => true,
            OperatorLinebreakFixer::class => [
                'position' => 'beginning',
                'only_booleans' => false,
            ],
            OrderedImportsFixer::class => [
                'imports_order' => ['class', 'function', 'const'],
                'sort_algorithm' => 'alpha',
            ],
            PhpdocAddMissingParamAnnotationFixer::class => [
                'only_untyped' => true,
            ],
            PhpdocAlignFixer::class => [
                'align' => 'vertical',
                'tags' => ['method', 'param', 'property', 'return', 'throws', 'type', 'var'],
            ],
            PhpdocAnnotationWithoutDotFixer::class => true,
            PhpdocIndentFixer::class => true,
            PhpdocInlineTagNormalizerFixer::class => true,
            PhpdocLineSpanFixer::class => [
                'const' => 'single',
                'property' => 'multi',
                'method' => 'multi',
            ],
            PhpdocNoAccessFixer::class => true,
            PhpdocNoAliasTagFixer::class => true,
            PhpdocNoEmptyReturnFixer::class => true,
            PhpdocNoPackageFixer::class => true,
            PhpdocNoUselessInheritdocFixer::class => true,
            PhpdocOrderFixer::class => true,
            PhpdocReturnSelfReferenceFixer::class => true,
            PhpdocScalarFixer::class => true,
            PhpdocSeparationFixer::class => true,
            PhpdocSingleLineVarSpacingFixer::class => true,
            PhpdocSummaryFixer::class => true,
            PhpdocTagCasingFixer::class => true,
            PhpdocTagTypeFixer::class => [
                'tags' => [
                    'api' => 'annotation',
                    'deprecated' => 'annotation',
                    'example' => 'annotation',
                    'global' => 'annotation',
                    'immutable' => 'annotation',
                    'internal' => 'annotation',
                    'license' => 'annotation',
                    'link' => 'annotation',
                    'method' => 'annotation',
                    'mixin' => 'annotation',
                    'param' => 'annotation',
                    'property' => 'annotation',
                    'readonly' => 'annotation',
                    'return' => 'annotation',
                    'see' => 'annotation',
                    'since' => 'annotation',
                    'throws' => 'annotation',
                    'todo' => 'annotation',
                    'uses' => 'annotation',
                    'var' => 'annotation',
                    'version' => 'annotation',
                ],
            ],
            PhpdocTrimConsecutiveBlankLineSeparationFixer::class => true,
            PhpdocTrimFixer::class => true,
            PhpdocTypesFixer::class => true,
            PhpdocTypesOrderFixer::class => [
                'sort_algorithm' => 'none',
                'null_adjustment' => 'always_last',
            ],
            PhpdocVarWithoutNameFixer::class => true,
            PowToExponentiationFixer::class => true,
            ProtectedToPrivateFixer::class => true,
            PsrAutoloadingFixer::class => true,
            RandomApiMigrationFixer::class => true,
            RegularCallableCallFixer::class => true,
            ReturnAssignmentFixer::class => true,
            SelfAccessorFixer::class => true,
            SelfStaticAccessorFixer::class => true,
            SemicolonAfterInstructionFixer::class => true,
            SetTypeToCastFixer::class => true,
            SimpleToComplexStringVariableFixer::class => true,
            SimplifiedIfReturnFixer::class => true,
            SimplifiedNullReturnFixer::class => true,
            SingleLineCommentStyleFixer::class => [
                'comment_types' => ['asterisk', 'hash'],
            ],
            SingleQuoteFixer::class => [
                'strings_containing_single_quote_chars' => false,
            ],
            SingleSpaceAfterConstructFixer::class => true,
            SingleTraitInsertPerStatementFixer::class => true,
            SpaceAfterSemicolonFixer::class => [
                'remove_in_empty_for_expressions' => false,
            ],
            StandardizeIncrementFixer::class => true,
            StandardizeNotEqualsFixer::class => true,
            StaticLambdaFixer::class => true,
            StrictComparisonFixer::class => true,
            StrictParamFixer::class => true,
            StringLineEndingFixer::class => true,
            SwitchContinueToBreakFixer::class => true,
            TernaryToElvisOperatorFixer::class => true,
            TernaryToNullCoalescingFixer::class => true,
            TrailingCommaInMultilineFixer::class => [
                'elements' => ['arrays', 'arguments'],
                'after_heredoc' => true,
            ],
            TrimArraySpacesFixer::class => true,
            TypesSpacesFixer::class => [
                'space' => 'none',
            ],
            UnaryOperatorSpacesFixer::class => true,
            UseArrowFunctionsFixer::class => true,
            VoidReturnFixer::class => true,
            WhitespaceAfterCommaInArrayFixer::class => true,
            YodaStyleFixer::class => [
                'equal' => false,
                'identical' => false,
                'less_and_greater' => false,
                'always_move_variable' => false,
            ],
        ];

        if ($this->isMinPhpCsFixerVersion('3.2')) {
            $rules[AssignNullCoalescingToCoalesceEqualFixer::class] = true;
            $rules[ControlStructureContinuationPositionFixer::class] = true;
            $rules[IntegerLiteralCaseFixer::class] = true;
            $rules[NoSpaceAroundDoubleColonFixer::class] = true;
            $rules[StringLengthToEmptyFixer::class] = true;
        }

        if ($this->isMinPhpCsFixerVersion('3.6')) {
            $rules[ClassReferenceNameCasingFixer::class] = true;
            $rules[NoUnneededImportAliasFixer::class] = true;
        }

        if ($this->isMinPhpCsFixerVersion('3.7')) {
            $rules[NoTrailingCommaInSinglelineFunctionCallFixer::class] = true;
            $rules[SingleLineCommentSpacingFixer::class] = true;
        }

        if ($this->isMinPhpCsFixerVersion('3.8')) {
            $rules[DateTimeCreateFromFormatCallFixer::class] = true;
            $rules[TypesSpacesFixer::class] = [
                'space' => 'none',
                'space_multiple_catch' => 'single',
            ];
        }

        if ($this->isMinPhpCsFixerVersion('3.9.1')) {
            $rules[ControlStructureBracesFixer::class] = true;
            $rules[CurlyBracesPositionFixer::class] = true;
            $rules[NoExtraBlankLinesFixer::class] = [
                'tokens' => [
                    'attribute',
                    'break',
                    'case',
                    'continue',
                    'curly_brace_block',
                    'default',
                    'extra',
                    'parenthesis_brace_block',
                    'return',
                    'square_brace_block',
                    'switch',
                    'throw',
                ],
            ];
            $rules[StatementIndentationFixer::class] = true;
        }

        if ($this->isMinPhpCsFixerVersion('3.9.5')) {
            $rules[NoMultipleStatementsPerLineFixer::class] = true;
        }

        if ($this->isMinPhpCsFixerVersion('3.10')) {
            $rules[WhitespaceAfterCommaInArrayFixer::class] = [
                'ensure_single_space' => true,
            ];
        }

        if ($this->isMinPhpCsFixerVersion('3.11')) {
            unset(
                $rules[NoTrailingCommaInSinglelineArrayFixer::class],
                $rules[NoTrailingCommaInSinglelineFunctionCallFixer::class]
            );

            $rules[NoTrailingCommaInSinglelineFixer::class] = true;
        }

        if ($this->isMinPhpCsFixerVersion('3.12')) {
            $rules[NoUselessConcatOperatorFixer::class] = true;
        }

        if ($this->isMinPhpCsFixerVersion('3.13')) {
            $rules[FunctionDeclarationFixer::class] = [
                'closure_function_spacing' => 'one',
                'closure_fn_spacing' => 'none',
                'trailing_comma_single_line' => false,
            ];
        }

        if ($this->isMinPhpCsFixerVersion('3.16')) {
            unset(
                $rules[BracesFixer::class],
                $rules[SingleSpaceAfterConstructFixer::class]
            );

            $rules[SingleSpaceAroundConstructFixer::class] = true;
        }

        if ($this->phpUnit) {
            $rules = array_merge(
                $rules,
                [
                    PhpUnitConstructFixer::class => [
                        'assertions' => ['assertEquals', 'assertSame', 'assertNotEquals', 'assertNotSame'],
                    ],
                    PhpUnitDedicateAssertFixer::class => [
                        'target' => '5.6',
                    ],
                    PhpUnitDedicateAssertInternalTypeFixer::class => [
                        'target' => '7.5',
                    ],
                    PhpUnitExpectationFixer::class => [
                        'target' => '8.4',
                    ],
                    PhpUnitInternalClassFixer::class => [
                        'types' => ['normal', 'final', 'abstract'],
                    ],
                    PhpUnitMethodCasingFixer::class => [
                        'case' => 'camel_case',
                    ],
                    PhpUnitMockFixer::class => [
                        'target' => '5.5',
                    ],
                    PhpUnitMockShortWillReturnFixer::class => true,
                    PhpUnitNamespacedFixer::class => [
                        'target' => '6.0',
                    ],
                    PhpUnitNoExpectationAnnotationFixer::class => [
                        'target' => '4.3',
                        'use_class_const' => true,
                    ],
                    PhpUnitSetUpTearDownVisibilityFixer::class => true,
                    // PhpUnitSizeClassFixer::class => [
                    //     'small',
                    //     'medium',
                    //     'large',
                    // ],
                    // PhpUnitStrictFixer::class => [
                    //     'assertAttributeEquals',
                    //     'assertAttributeNotEquals',
                    //     'assertEquals',
                    //     'assertNotEquals',
                    // ],
                    PhpUnitTestAnnotationFixer::class => [
                        'style' => 'prefix',
                    ],
                    PhpUnitTestCaseStaticMethodCallsFixer::class => [
                        'call_type' => 'static',
                    ],
                    // PhpUnitTestClassRequiresCoversFixer::class => true,
                ],
            );

            if ($this->isMinPhpCsFixerVersion('3.14')) {
                $rules[PhpUnitDataProviderStaticFixer::class] = true;
            }
        }

        if ($this->doctrine) {
            $rules = array_merge(
                $rules,
                [
                    DoctrineAnnotationArrayAssignmentFixer::class => true,
                    DoctrineAnnotationBracesFixer::class => true,
                    DoctrineAnnotationIndentationFixer::class => true,
                    DoctrineAnnotationSpacesFixer::class => [
                        'before_array_assignments_equals' => false,
                        'after_array_assignments_equals' => false,
                        'before_array_assignments_colon' => false,
                        'after_array_assignments_colon' => false,
                    ],
                ],
            );
        }

        if ($this->typeInfer) {
            $rules = array_merge(
                $rules,
                [
                    PhpdocToParamTypeFixer::class => true,
                    PhpdocToPropertyTypeFixer::class => true,
                    PhpdocToReturnTypeFixer::class => true,
                ],
            );
        }

        return $rules;
    }

    /**
     * @return PhpCsFixerRuleList
     */
    private function getKubawerlosFixerRules(): array
    {
        $rules = [
            CommentSurroundedBySpacesFixer::class => true,
            ConstructorEmptyBracesFixer::class => true,
            IssetToArrayKeyExistsFixer::class => true,
            NoCommentedOutCodeFixer::class => true,
            NoDuplicatedArrayKeyFixer::class => [
                'ignore_expressions' => true,
            ],
            NoLeadingSlashInGlobalNamespaceFixer::class => true,
            NoNullableBooleanTypeFixer::class => true,
            NoPhpStormGeneratedCommentFixer::class => true,
            NoSuperfluousConcatenationFixer::class => [
                'allow_preventing_trailing_spaces' => true,
            ],
            NoTrailingCommaInSinglelineFixer::class => true,
            NoUselessCommentFixer::class => true,
            NoUselessDirnameCallFixer::class => true,
            NoUselessParenthesisFixer::class => true,
            NumericLiteralSeparatorFixer::class => [
                'decimal' => true,
                'float' => true,
            ],
            PhpdocArrayStyleFixer::class => true,
            PhpdocNoSuperfluousParamFixer::class => true,
            PhpdocParamOrderFixer::class => true,
            PhpdocParamTypeFixer::class => true,
            PhpdocSelfAccessorFixer::class => true,
            PhpdocTypesTrimFixer::class => true,
        ];

        if ($this->isMinKubawerlosVersion('3.9')) {
            $rules[PhpdocTypesCommaSpacesFixer::class] = true;
        }

        if ($this->isMinKubawerlosVersion('3.14')) {
            $rules[EmptyFunctionBodyFixer::class] = true;
        }

        if ($this->phpUnit) {
            $rules = array_merge(
                $rules,
                [
                    DataProviderNameFixer::class => [
                        'prefix' => '',
                        'suffix' => 'Provider',
                    ],
                ],
            );
        }

        if ($this->doctrine) {
            $rules = array_merge(
                $rules,
                [
                    NoDoctrineMigrationsGeneratedCommentFixer::class => true,
                    NoUselessDoctrineRepositoryCommentFixer::class => true,
                ],
            );
        }

        return $rules;
    }

    /**
     * @return PhpCsFixerRuleList
     */
    private function getPedroTrollerFixerRules(): array
    {
        return [
            CommentLineToPhpdocBlockFixer::class => true,
            ExceptionsPunctuationFixer::class => true,
            ForbiddenFunctionsFixer::class => [
                'functions' => ['sizeof', 'var_dump', 'die'],
            ],
            LineBreakBetweenMethodArgumentsFixer::class => [
                'max-args' => false,
                'automatic-argument-merge' => false,
            ],
        ];
    }

    /**
     * @return PhpCsFixerRuleList
     */
    private function getSymplifyFixerRules(): array
    {
        return [
            DocBlockLineLengthFixer::class => true,
            LineLengthFixer::class => [
                'inline_short_lines' => false,
            ],
            MethodChainingNewlineFixer::class => true,
            ParamReturnAndVarTagMalformsFixer::class => true,
            RemoveUselessDefaultCommentFixer::class => true,
            StandaloneLineInMultilineArrayFixer::class => true,
        ];
    }

    /**
     * @return PhpCsFixerRuleList
     */
    private function getJuliangutFixerRules(): array
    {
        return [
            FloatLeadingZeroFixer::class => true,
            LeadingUppercaseCommentFixer::class => true,
            PhpdocLeadingUppercaseSummaryFixer::class => true,
        ];
    }

    /**
     * @return PhpCodeSnifferRuleList
     */
    private function getPhpCodeSnifferRules(): array
    {
        return [
            CommentedOutCodeSniff::class => [
                'maxPercentage' => 70,
            ],
            DeprecatedFunctionsSniff::class => true,
            DisallowRequestSuperglobalSniff::class => true,
            EvalSniff::class => true,
            FixmeSniff::class => true,
            ForLoopWithTestFunctionCallSniff::class => true,
            FunctionCommentThrowTagSniff::class => true,
            GitMergeConflictSniff::class => true,
            LineLengthSniff::class => [
                'lineLimit' => 120,
                'absoluteLineLimit' => 0,
            ],
            JumbledIncrementerSniff::class => true,
            MemberVarScopeSniff::class => true,
            NestingLevelSniff::class => [
                'absoluteNestingLevel' => 3,
            ],
            NoSilencedErrorsSniff::class => true,
            OneObjectStructurePerFileSniff::class => true,
            StaticThisUsageSniff::class => true,
            TodoSniff::class => true,
            UnconditionalIfStatementSniff::class => true,
            UnnecessaryFinalModifierSniff::class => true,
            UpperCaseConstantNameSniff::class => true,
            UselessOverridingMethodSniff::class => true,
        ];
    }

    /**
     * @return PhpCodeSnifferRuleList
     */
    private function getSlevomatSnifferRules(): array
    {
        $rules = [
            AssignmentInConditionSniff::class => [
                'ignoreAssignmentsInsideFunctionCalls' => true,
            ],
            ClassConstantVisibilitySniff::class => true,
            DeadCatchSniff::class => true,
            DisallowContinueWithoutIntegerOperandInSwitchSniff::class => true,
            DisallowEmptySniff::class => true,
            DisallowImplicitArrayCreationSniff::class => true,
            DisallowLateStaticBindingForConstantsSniff::class => true,
            DisallowMultiConstantDefinitionSniff::class => true,
            DisallowMultiPropertyDefinitionSniff::class => true,
            EmptyCommentSniff::class => true,
            ReferenceSpacingSniff::class => true,
            ReferenceThrowableOnlySniff::class => true,
            RequireCombinedAssignmentOperatorSniff::class => true,
            RequireMultiLineCallSniff::class => true,
            RequireMultiLineConditionSniff::class => [
                'booleanOperatorOnPreviousLine' => false,
            ],
            RequireMultiLineTernaryOperatorSniff::class => [
                'lineLengthLimit' => 121,
            ],
            RequireNullCoalesceEqualOperatorSniff::class => true,
            RequireNullCoalesceOperatorSniff::class => true,
            RequireOnlyStandaloneIncrementAndDecrementOperatorsSniff::class => true,
            RequireShortTernaryOperatorSniff::class => true,
            UnusedInheritedVariablePassedToClosureSniff::class => true,
            UselessAliasSniff::class => true,
            UselessConstantTypeHintSniff::class => true,
            UselessInheritDocCommentSniff::class => true,
            UselessLateStaticBindingSniff::class => true,
            UselessParameterDefaultValueSniff::class => true,
            UselessParenthesesSniff::class => true,
            UselessSemicolonSniff::class => true,
        ];

        if ($this->isMinSlevomatVersion('8.9')) {
            $rules[DisallowTrailingMultiLineTernaryOperatorSniff::class] = true;
            $rules[DisallowVariableVariableSniff::class] = true;
        }

        if ($this->isMinSlevomatVersion('8.10')) {
            $rules[DisallowStringExpressionPropertyFetchSniff::class] = true;
            $rules[DisallowVariableParsingSniff::class] = true;
        }

        if ($this->typeInfer) {
            $rules = array_merge(
                $rules,
                [
                    ParameterTypeHintSniff::class => true,
                    PropertyTypeHintSniff::class => true,
                    ReturnTypeHintSniff::class => true,
                ],
            );
        }

        return $rules;
    }

    /**
     * @return PhpCodeSnifferRuleList
     */
    private function getJuliangutSnifferRules(): array
    {
        return [
            CamelCapsFunctionNameSniff::class => true,
            CamelCapsVariableNameSniff::class => true,
            EmptyStatementSniff::class => true,
        ];
    }

    /**
     * @return array<class-string<Sniff|FixerInterface>>
     */
    protected function getSkips(): array
    {
        return [];
    }

    /**
     * @param array<string|class-string<Sniff|FixerInterface>, bool|array<string, mixed>> $additionalRules
     */
    final public function setAdditionalRules(array $additionalRules): self
    {
        $this->additionalRules = $additionalRules;

        return $this;
    }

    /**
     * @param array<class-string<Sniff|FixerInterface>> $additionalSkips
     */
    public function setAdditionalSkips(array $additionalSkips): self
    {
        $this->additionalSkips = $additionalSkips;

        return $this;
    }

    final public function setHeader(string $header): self
    {
        $this->header = $header;

        return $this;
    }

    private function getHeader(): ?string
    {
        if ($this->header === null) {
            return null;
        }

        $header = str_replace(
            ['/**', ' */', ' * ', ' *', '{{year}}', '{{package}}'],
            ['', '', '', '', (new DateTimeImmutable('now'))->format('Y'), InstalledVersions::getRootPackage()['name']],
            $this->header,
        );

        return trim($header) !== '' ? trim($header) : null;
    }

    final public function enablePhpUnitRules(bool $phpUnit = true): self
    {
        $this->phpUnit = $phpUnit;

        return $this;
    }

    final public function enableDoctrineRules(bool $doctrine = true): self
    {
        $this->doctrine = $doctrine;

        return $this;
    }

    final public function enableTypeInferRules(bool $typeInfer = true): self
    {
        $this->typeInfer = $typeInfer;

        return $this;
    }

    final protected function isMinPhpCsFixerVersion(string $version): bool
    {
        return $this->isMinLibraryVersion('friendsofphp/php-cs-fixer', $version);
    }

    final protected function isMinKubawerlosVersion(string $version): bool
    {
        return $this->isMinLibraryVersion('kubawerlos/php-cs-fixer-custom-fixers', $version);
    }

    final protected function isMinSlevomatVersion(string $version): bool
    {
        return $this->isMinLibraryVersion('slevomat/coding-standard', $version);
    }

    private function isMinLibraryVersion(string $library, string $comparisonVersion): bool
    {
        return version_compare(
            (string) preg_replace('/^v/', '', InstalledVersions::getPrettyVersion($library) ?? ''),
            $comparisonVersion,
            '>=',
        );
    }
}
