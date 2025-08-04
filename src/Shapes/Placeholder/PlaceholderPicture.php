<?php

namespace Imoing\Pptx\Shapes\Placeholder;

use Imoing\Pptx\Shapes\Picture\Picture;

class PlaceholderPicture extends Picture
{
    use InheritsDimensions;

    protected function getBasePlaceholder(): mixed
    {
        list($layout, $idx) = [$this->part->slideLayout, $this->_element->phIdx];

        return $layout->placeholders->get($idx);
    }
}