<?php

/*
 * This file is part of the zurb-ink-bundle package.
 *
 * (c) Marco Polichetti <gremo1982@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gremo\ZurbInkBundle\Twig\Parser;

use Gremo\ZurbInkBundle\Twig\Node\InlineCssNode;
use Twig_Token;
use Twig_TokenParser;

class InlineCssTokenParser extends Twig_TokenParser
{
    /**
     * {@inheritdoc}
     */
    public function parse(Twig_Token $token)
    {
        $parser = $this->parser;
        $stream = $parser->getStream();

        $stream->expect(Twig_Token::BLOCK_END_TYPE);
        $html = $this->parser->subparse(array($this, 'decideBlockEnd'), true);
        $stream->expect(Twig_Token::BLOCK_END_TYPE);

        return new InlineCssNode($html, $token->getLine(), $this->getTag());
    }

    /**
     * @param Twig_Token $token
     * @return bool
     */
    public function decideBlockEnd(Twig_Token $token)
    {
        return $token->test('endinlinestyle');
    }

    /**
     * {@inheritdoc}
     */
    public function getTag()
    {
        return "inlinestyle";
    }
}
