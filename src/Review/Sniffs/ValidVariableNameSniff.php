<?php

namespace Review\Sniffs;

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
        $tokens = $phpcsFile->getTokens();
        $varName = ltrim($tokens[$stackPtr]['content'], '$');

        // Verifica se o token é uma propriedade de classe (não é uma variável comum nem uso de self::$var)
        $isProperty = false;
        for ($i = $stackPtr; $i >= 0; $i--) {
            if ($tokens[$i]['code'] === T_CLASS || $tokens[$i]['code'] === T_TRAIT) {
                break;
            }

            if ($tokens[$i]['code'] === T_VARIABLE && $i !== $stackPtr) {
                // Encontramos outra variável antes: não é declaração de propriedade
                return;
            }

            if (in_array($tokens[$i]['code'], [T_PUBLIC, T_PROTECTED, T_PRIVATE, T_VAR, T_STATIC])) {
                $isProperty = true;
            }

            if ($tokens[$i]['code'] === T_FUNCTION) {
                // Estamos dentro de uma função, logo não é declaração de propriedade
                return;
            }

            // Parar no ponto em que abrimos a classe
            if ($tokens[$i]['code'] === T_OPEN_CURLY_BRACKET) {
                break;
            }
        }

        if (! $isProperty) {
            return;
        }

        // Verifica se a propriedade é estática
        $isStatic = false;
        for ($i = $stackPtr - 1; $i >= 0; $i--) {
            if ($tokens[$i]['code'] === T_STATIC) {
                $isStatic = true;
                break;
            }

            if (in_array($tokens[$i]['code'], [T_PUBLIC, T_PROTECTED, T_PRIVATE, T_VAR, T_FUNCTION])) {
                break;
            }
        }

        if ($isStatic) {
            if (! preg_match('/^[A-Z][A-Z0-9_]*$/', $varName)) {
                $phpcsFile->addError(
                    "Static property \${$varName} must be in UPPER_SNAKE_CASE.",
                    $stackPtr,
                    'StaticPropertyNotUpperSnakeCase'
                );
            }
        } else {
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
