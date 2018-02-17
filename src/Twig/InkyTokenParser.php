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

class InkyTokenParser extends \Twig_TokenParser
{
    /**
     * {@inheritdoc}
     */
    public function parse(Twig_Token $token)
    {
        $lineno = $token->getLine();
        $this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse(array($this, 'decideBlockEnd'), true);
        $this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);

        return new InkyNode($body, $lineno, $this->getTag());
    }

    /**
     * @param Twig_Token $token
     * @return bool
     */
    public function decideBlockEnd(\Twig_Token $token)
    {
        return $token->test('endinky');
    }

    /**
     * {@inheritdoc}
     */
    public function getTag()
    {
        return 'inky';
    }
}
