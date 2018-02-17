<?php

namespace Hampe\ZurbInkBundle\Twig;

use Twig_Token;

class InkyTokenParser extends \Twig_TokenParser
{
    const TAG = 'inky';

    /**
     * {@inheritdoc}
     */
    public function parse(Twig_Token $token)
    {
        $lineno = $token->getLine();
        $this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse(array($this, 'decideInkyEnd'), true);
        $this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);

        return new InkyNode($body, $lineno, $this->getTag());
    }

    /**
     * {@inheritdoc}
     */
    public function getTag()
    {
        return self::TAG;
    }

    public function decideInkyEnd(\Twig_Token $token)
    {
        return $token->test('end'.self::TAG);
    }
}
