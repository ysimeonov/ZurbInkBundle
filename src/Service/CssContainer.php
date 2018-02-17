<?php

namespace Hampe\Bundle\ZurbInkBundle\Service;

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
