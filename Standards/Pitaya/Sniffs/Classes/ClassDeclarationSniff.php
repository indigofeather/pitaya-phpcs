<?php

class Pitaya_Sniffs_Classes_ClassDeclarationSniff extends PEAR_Sniffs_Classes_ClassDeclarationSniff
{

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param integer              $stackPtr  The position of the current token in the
     *                                        stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $errorData = array($tokens[$stackPtr]['content']);
        // braces
        $openingBrace = $tokens[$stackPtr]['scope_opener'];
        $closingBrace = $tokens[$stackPtr]['scope_closer'];
        // look for empty bodies
        $body = $phpcsFile->getTokensAsString(
            $openingBrace, $closingBrace - $openingBrace + 1
        );
        if (preg_match('/^\{\s*\}$/', $body)) {
            if (preg_match('/\s/', $body)) {
                $error = 'Opening and closing braces of an empty %s must be on 
                    the same line as the definition, with no spaces between them.';
                $phpcsFile->addError(
                    $error, $stackPtr, 'EmptyBodyBraces', $errorData
                );
            }
            // body has content
        } else {
            parent::process($phpcsFile, $stackPtr);
            // check braces alignment
            if ($tokens[$openingBrace]['column'] !== $tokens[$closingBrace]['column']) {
                $error = 'Closing braces must have the same indentation than 
                    their respective opening one.';
                $phpcsFile->addError(
                    $error, $closingBrace, 'BadClosingBraceIndentation', $errorData
                );
            }
        }
    } //end process()

}

//end class
?>
