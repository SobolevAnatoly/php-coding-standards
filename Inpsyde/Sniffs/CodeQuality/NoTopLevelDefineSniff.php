<?php

/*
 * This file is part of the php-coding-standards package.
 *
 * (c) Inpsyde GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Inpsyde\Sniffs\CodeQuality;

use Inpsyde\PhpcsHelpers;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class NoTopLevelDefineSniff implements Sniff
{
    /**
     * @return int[]
     */
    public function register()
    {
        return [T_STRING];
    }

    /**
     * @param File $file
     * @param int $position
     * @return void
     */
    public function process(File $file, $position)
    {
        $token = $file->getTokens()[$position];

        if (
            ($token['content'] ?? '') !== 'define'
            || ($token['level'] ?? -1) !== 0
            || !PhpcsHelpers::isFunctionCall($file, $position)
        ) {
            return;
        }

        $file->addWarning(
            'Do not use "define" for top-level constant definition. Prefer "const" instead.',
            $position,
            'Found'
        );
    }
}
