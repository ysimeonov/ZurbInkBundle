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
use Twig_Environment;
use Twig_Node;

class InlineCssNode extends Twig_Node
{
    public function __construct(Twig_Node $html, $lineno = 0, $tag = 'inlinestyle')
    {
        parent::__construct(array('html' => $html), array(), $lineno, $tag);
    }

    /**
     * {@inheritdoc}
     */
    public function compile(Twig_Compiler $compiler)
    {
        $extensionName = (version_compare(Twig_Environment::VERSION, '1.26.0') >= 0)
            ? 'Gremo\ZurbInkBundle\Twig\InlineCssExtension'
            : 'zurb_ink.inlinecss'
        ;

        $compiler
            ->addDebugInfo($this)
            ->write("ob_start();". PHP_EOL)
            ->subcompile($this->getNode('html'))
            ->write("echo \$this->env->getExtension('{$extensionName}')->inlineStyles(ob_get_clean());" . PHP_EOL)
        ;
    }
}
