<?php

namespace Imoing\Pptx\Shapes\Placeholder;

use Imoing\Pptx\Shapes\Base\Transform2D;

class SlidePlaceholder extends BaseSlidePlaceholder
{
    private ?Transform2D $_transform = null;
    public function getTransform2D(): Transform2D
    {
        if (is_null($this->_transform)) {
            $xfrm = $this->_element->getXfrm();
            if (!$xfrm) {
                $xfrm = $this->getBasePlaceholder()->element->getXfrm();
            }
            $this->_transform = new Transform2D($xfrm, $this->_parent->getTransform2D());
        }

        return $this->_transform;
    }
}