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

use Twig_Compiler;
use Twig_Node;

class InlineCssNode extends Twig_Node
{
    public function __construct($html, $line = 0, $tag = 'inlinestyle')
    {
        parent::__construct(array('html' => $html), array(), $line, $tag);
    }

    /**
     * {@inheritdoc}
     */
    public function compile(Twig_Compiler $compiler)
    {
        $compiler
            ->write("ob_start();\n")
            ->subcompile($this->getNode('html'))
            ->write('$zurbCss = "";')
            ->write('foreach($context["zurb_ink_styles"] as $cssFile){')
            ->write('$path = $context["zurb_ink_locator"]->locate($cssFile);')
            ->write('if($path){$zurbCss .= "\n".file_get_contents($path);}')
            ->write('}')
            ->write('$context["zurb_ink_inlinecss"]->setHtml(ob_get_clean());')
            ->write('$context["zurb_ink_inlinecss"]->setCSS($zurbCss);')
            ->write('echo $context["zurb_ink_inlinecss"]->convert();')
            ->write('$context["zurb_ink_styles"]->removeAll();')
        ;
    }
}
