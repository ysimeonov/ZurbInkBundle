<?php

namespace Hampe\Bundle\ZurbInkBundle\Twig;

use Twig_Node;

class InkyNode extends Twig_Node
{
    public function __construct(\Twig_Node $body, $lineno, $tag = 'inky')
    {
        parent::__construct(array('body' => $body), array(), $lineno, $tag);
    }

    /**
     * {@inheritdoc}
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $extensionName = (version_compare(\Twig_Environment::VERSION, '1.26.0') >= 0) ?
            'Hampe\Bundle\ZurbInkBundle\Twig\InkyExtension'
            : InkyExtension::NAME
        ;

        $compiler
            ->addDebugInfo($this)
            ->write('ob_start();' . PHP_EOL)
            ->subcompile($this->getNode('body'))
            ->write('$inkyHtml = ob_get_clean();' . PHP_EOL)
            ->write("echo \$this->env->getExtension('{$extensionName}')->parse(\$inkyHtml);" . PHP_EOL);
    }
}
