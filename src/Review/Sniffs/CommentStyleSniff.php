<?php

namespace Review\Sniffs;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class CommentStyleSniff implements Sniff
{
    public function register(): array
    {
        return [T_COMMENT, T_DOC_COMMENT_OPEN_TAG];
    }

    public function process(File $phpcsFile, $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];
        $content = trim($token['content']);
        $line = $token['line'];
        $column = $token['column'];

        // Handle PHPDoc
        if ($token['code'] === T_DOC_COMMENT_OPEN_TAG) {
            // PHPDoc only allowed for classes, methods, functions, and properties
            $nextCode = $phpcsFile->findNext([T_CLASS, T_FUNCTION, T_VARIABLE, T_PUBLIC, T_PROTECTED, T_PRIVATE], $stackPtr);
            if ($nextCode === false || $tokens[$nextCode]['line'] !== $line + 1) {
                $phpcsFile->addError('PHPDoc comments (/** */) are only allowed for classes, methods, and properties.', $stackPtr, 'InvalidPHPDocLocation');
            }
            return;
        }

        // Handle regular comments
        if (strpos($content, '//') === 0) {
            $isLineDecoration = preg_match('/^\/\/[-=]{10,}\/$/', $content);
            $isBlockTitle = preg_match('/^\/\/[-=]{10,}\/$/', $content) &&
                            isset($tokens[$stackPtr + 1]) &&
                            isset($tokens[$stackPtr + 2]) &&
                            preg_match('/^\/\/.+$/', trim($tokens[$stackPtr + 1]['content'])) &&
                            preg_match('/^\/\/[-=]{10,}\/$/', trim($tokens[$stackPtr + 2]['content']));

            // If part of the full block comment, validate width
            if ($isLineDecoration) {
                $length = strlen($content);
                if ($length !== 120) {
                    $phpcsFile->addWarning('Comment block line must be exactly 120 characters.', $stackPtr, 'InvalidBlockLength');
                }
                return;
            }

            if (!$isBlockTitle) {
                // Short inline comment rule
                $text = trim(substr($content, 2));
                if (strlen($text) > 40) {
                    $phpcsFile->addWarning('Inline comment should be short (max 40 chars) or use block format.', $stackPtr, 'TooLongInlineComment');
                }
            }

            // Ensure comment is aligned with next line of code
            $nextLinePtr = $phpcsFile->findNext(T_WHITESPACE, $stackPtr + 1, null, true);
            if ($nextLinePtr !== false && $tokens[$nextLinePtr]['line'] === $line + 1) {
                if ($tokens[$nextLinePtr]['column'] !== $column) {
                    $phpcsFile->addWarning('Comment must be indented at same column as the next line of code.', $stackPtr, 'MisalignedComment');
                }
            }
        }
    }
}
