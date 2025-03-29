<?php

namespace Sniffs;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class ValidVariableNameSniff implements Sniff
{
    /**
     * @return array|int[]|string[]
     */
    public function register(): array
    {
        return [T_VARIABLE];
    }

    /**
     * @param File $phpcsFile
     * @param      $stackPtr
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr): void
    {
        $tokens  = $phpcsFile->getTokens();
        $varName = ltrim($tokens[$stackPtr]['content'], '$');

        // Detect scope: is it a property?
        $isStatic   = false;
        $conditions = $tokens[$stackPtr]['conditions'] ?? [];

        foreach (array_reverse($conditions) as $ptr => $type) {
            if (in_array($type, [T_CLASS, T_TRAIT])) {
                // Look backward to find if it's declared as static
                for ($i = $stackPtr - 1; $i > $ptr; $i--) {
                    if ($tokens[$i]['code'] === T_STATIC) {
                        $isStatic = true;

                        break;
                    }

                    if ($tokens[$i]['code'] === T_FUNCTION || $tokens[$i]['code'] === T_VARIABLE) {
                        break;
                    }
                }

                break;
            }
        }

        if ($isStatic) {
            // Static property: must be UPPER_SNAKE_CASE
            if (! preg_match('/^[A-Z][A-Z0-9_]*$/', $varName)) {
                $phpcsFile->addError(
                    "Static property \${$varName} must be in UPPER_SNAKE_CASE.",
                    $stackPtr,
                    'StaticPropertyNotUpperSnakeCase'
                );
            }
        } else {
            // Other variables: must be lower_snake_case
            if (! preg_match('/^[a-z][a-z0-9_]*$/', $varName)) {
                $phpcsFile->addError(
                    "Variable \${$varName} must be in lower_snake_case.",
                    $stackPtr,
                    'VariableNotLowerSnakeCase'
                );
            }
        }
    }
}
