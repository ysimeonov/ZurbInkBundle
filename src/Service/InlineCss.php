<?php

/*
 * This file is part of the zurb-ink-bundle package.
 *
 * (c) Marco Polichetti <gremo1982@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gremo\ZurbInkBundle\Service;

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class InlineCss
{
    /**
     * @var CssToInlineStyles
     */
    protected $cssToInlineStyles;

    public function setCss($css)
    {
        $this->getCssToInlineStyles()->setCSS($css);
    }

    public function setHtml($html)
    {
        $this->getCssToInlineStyles()->setHTML($html);
    }

    public function convert()
    {
        $html = $this->getCssToInlineStyles()->convert();
        // reset the whole InlineStyles Object (it does not reset the parsed css-rules after ::convert())
        $this->cssToInlineStyles = null;

        return $html;
    }

    /**
     *
     * @return CssToInlineStyles
     */
    protected function getCssToInlineStyles()
    {
        if (!$this->cssToInlineStyles) {
            $this->cssToInlineStyles = new CssToInlineStyles();
        }

        return $this->cssToInlineStyles;
    }
}
