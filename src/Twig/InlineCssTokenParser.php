<?php

/*
 * This file is part of the zurb-ink-bundle package.
 *
 * (c) Marco Polichetti <gremo1982@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gremo\ZurbInkBundle\Twig;

use Twig_Token;
use Twig_TokenParser;

class InlineCssTokenParser extends Twig_TokenParser
{

    public function __construct()
    {
    }

    public function parse(Twig_Token $token)
    {
        $parser = $this->parser;
        $stream = $parser->getStream();

        $stream->expect(Twig_Token::BLOCK_END_TYPE);
        $html = $this->parser->subparse(array($this, 'decideEnd'), true);
        $stream->expect(Twig_Token::BLOCK_END_TYPE);

        return new InlineCssNode($html, $token->getLine(), $this->getTag());
    }

    public function getTag()
    {
        return "inlinestyle";
    }

    public function decideEnd(Twig_Token $token)
    {
        return $token->test('endinlinestyle');
    }
}
