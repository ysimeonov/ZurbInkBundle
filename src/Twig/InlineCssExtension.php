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
use Gremo\ZurbInkBundle\Service\InlineCss;
use Symfony\Component\Config\FileLocatorInterface;
use Twig_Extension;
use Twig_Extension_GlobalsInterface;
use Twig_SimpleFunction;

class InlineCssExtension extends Twig_Extension implements Twig_Extension_GlobalsInterface
{
    protected $inlineCss;
    protected $fileLocator;

    public function __construct(InlineCss $inlineCss, FileLocatorInterface $fileLocator)
    {
        $this->inlineCss = $inlineCss;
        $this->fileLocator = $fileLocator;
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        $cssContainer = new CssContainer();

        return array(
            "zurb_ink_inlinecss" => $this->inlineCss,
            "zurb_ink_locator" => $this->fileLocator,
            "zurb_ink_styles" => $cssContainer
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('includeStyles', array($this, 'includeStyles')),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenParsers()
    {
        return array(
            new InlineCssTokenParser(),
        );
    }

    /**
     * @param mixed $styles
     * @return string
     */
    public function includeStyles($styles)
    {
        if (is_string($styles)) {
            $styles = array($styles);
        }

        $style = null;
        foreach ($styles as $styleFile) {
            $path = $this->fileLocator->locate($styleFile);
            $style .= file_get_contents($path).PHP_EOL.PHP_EOL;
        }

        return (string) $style;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "zurb_ink.inlinecss";
    }
}
