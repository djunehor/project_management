<?php

namespace Dompdf\Frame;

use Dompdf\Frame;
use IteratorAggregate;

/**
 * Pre-order IteratorAggregate.
 */
class FrameTreeList implements IteratorAggregate
{
    /**
     * @var \Dompdf\Frame
     */
    protected $_root;

    /**
     * @param \Dompdf\Frame $root
     */
    public function __construct(Frame $root)
    {
        $this->_root = $root;
    }

    /**
     * @return FrameTreeIterator
     */
    public function getIterator()
    {
        return new FrameTreeIterator($this->_root);
    }
}
