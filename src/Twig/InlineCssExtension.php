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

use Gremo\ZurbInkBundle\Service\CssContainer;
use Twig_Extension;
use Twig_Extension_GlobalsInterface;
use Twig_SimpleFunction;

class InlineCssExtension extends Twig_Extension implements Twig_Extension_GlobalsInterface
{
    protected $inlineCss;
    protected $fileLocator;

    public function __construct($inlineCss, $fileLocator)
    {
        $this->inlineCss = $inlineCss;
        $this->fileLocator = $fileLocator;
    }

    public function getName()
    {
        return "zurb_ink.inlinecss";
    }

    public function getGlobals()
    {
        $cssContainer = new CssContainer();

        return array(
            "zurb_ink_inlinecss" => $this->inlineCss,
            "zurb_ink_locator" => $this->fileLocator,
            "zurb_ink_styles" => $cssContainer
        );
    }

    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('includeStyles', array($this, 'includeStyles'))
        );
    }

    public function getTokenParsers()
    {
        return array(
            new InlineCssTokenParser()
        );
    }

    public function includeStyles($styles)
    {
        $locator = $this->fileLocator;
        $style = "";
        foreach ($styles as $styleFile) {
            $path = $locator->locate($styleFile);
            $style .= "\n\n".file_get_contents($path);
        }

        return $style;
    }
}
