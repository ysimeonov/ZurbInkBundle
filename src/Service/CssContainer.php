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

class CssContainer implements \IteratorAggregate
{
    protected $cssFiles = array();

    public function add($file)
    {
        $this->cssFiles[] = $file;
    }

    public function removeAll()
    {
        $this->cssFiles = array();
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->cssFiles);
    }
}
