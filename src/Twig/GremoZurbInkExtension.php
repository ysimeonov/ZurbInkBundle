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

use Gremo\ZurbInkBundle\Twig\Parser\InkyTokenParser;
use Gremo\ZurbInkBundle\Twig\Parser\InlineCssTokenParser;
use Gremo\ZurbInkBundle\Util\HtmlUtils;
use Symfony\Component\Config\FileLocatorInterface;
use Twig_SimpleFunction;

class GremoZurbInkExtension extends \Twig_Extension
{
    const NAME = 'gremo_zub_ink';

    private $htmlUtils;
    private $fileLocator;
    private $inlineResources = array();

    public function __construct(HtmlUtils $htmlUtils, FileLocatorInterface $fileLocator)
    {
        $this->htmlUtils = $htmlUtils;
        $this->fileLocator = $fileLocator;
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenParsers()
    {
        return array(
            new InkyTokenParser(),
            new InlineCssTokenParser(),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('zurb_ink_add_stylesheet', array($this, 'addStylesheet')),
        );
    }

    /**
     * @param string $resource
     * @param bool $alsoOutput
     * @return null|string
     */
    public function addStylesheet($resource, $alsoOutput = false)
    {
        if (!isset($this->inlineResources[$resource])) {
            $this->inlineResources[$resource] = $this->fileLocator->locate($resource);
        }

        if ($alsoOutput) {
            return $this->getContents($resource);
        }
    }

    /**
     * @param null|string $resource
     */
    public function removeStylesheet($resource = null)
    {
        if (null === $resource) {
            $this->inlineResources = array();

            return;
        }

        unset($this->inlineResources[$resource]);
    }

    /**
     * @param string $html
     * @return string
     */
    public function inlineCss($html)
    {
        return $this->htmlUtils->inlineCss($html, $this->getContents($this->inlineResources));
    }

    /**
     * @param string $contents
     * @return string
     */
    public function convertInkyToHtml($contents)
    {
        return $this->htmlUtils->parseInky($contents);
    }

    /**
     * @param string|array $resources
     * @return string
     */
    private function getContents($resources)
    {
        $styles = array();
        foreach ((array) $resources as $key => $resource) {
            // Resource key already in the cache of inlined resources, avoid locating it
            if (isset($this->inlineResources[$key])) {
                $resource = $this->inlineResources[$key];
            } else {
                $resource = $this->fileLocator->locate($resource);
            }

            $styles[] = file_get_contents($resource);
        }

        return implode(PHP_EOL, $styles);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }
}
