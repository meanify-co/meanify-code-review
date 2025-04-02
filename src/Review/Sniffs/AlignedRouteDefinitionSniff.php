<?php

namespace Review\Sniffs;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class AlignedRouteDefinitionSniff implements Sniff
{
    public function register(): array
    {
        return [T_STRING];
    }

    public function process(File $phpcsFile, $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();

        if (strtolower($tokens[$stackPtr]['content']) !== 'route') {
            return;
        }

        $next = $phpcsFile->findNext(T_DOUBLE_COLON, $stackPtr + 1);
        if (! $next || $next !== $stackPtr + 1) {
            return;
        }

        $methodPtr = $phpcsFile->findNext(T_STRING, $next + 1);
        if (! $methodPtr) {
            return;
        }

        $method = strtolower($tokens[$methodPtr]['content']);

        if (!in_array($method, ['get', 'post', 'put', 'delete', 'patch', 'options'])) {
            return;
        }


        $openParen = $phpcsFile->findNext(T_OPEN_PARENTHESIS, $methodPtr + 1);
        if (! $openParen) {
            return;
        }

        $line = $tokens[$stackPtr]['line'];
        $colRoute = $tokens[$stackPtr]['column'];
        $colMethod = $tokens[$methodPtr]['column'];
        $colParen = $tokens[$openParen]['column'];

        if (($colRoute !== 1) || ($colMethod !== 8) || ($colParen !== 13)) {
            $phpcsFile->addWarning(
                'Route definition is not aligned: use spacing to align method and URI (e.g., Route::get (...)).',
                $stackPtr,
                'RouteNotAligned'
            );
        }
    }
}
