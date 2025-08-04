<?php

namespace Imoing\Pptx\Shapes\Base;

use Imoing\Pptx\Enum\PPPlaceholderType;
use Imoing\Pptx\OXml\Shapes\Shared\CTPlaceholder;
use Imoing\Pptx\Shared\ElementProxy;

/**
 * @property-read CTPlaceholder $element
 * @property-read int $idx
 * @property-read PPPlaceholderType $type
 */
class PlaceholderFormat extends ElementProxy
{
    protected CTPlaceholder $_ph;
    public function __construct(CTPlaceholder $element)
    {
        parent::__construct($element);
        $this->_ph = $element;
    }

    public function getElement(): CTPlaceholder
    {
        return $this->_ph;
    }

    public function getIdx(): int
    {
        return $this->_ph->idx;
    }

    public function getType(): PPPlaceholderType
    {
        return $this->_ph->type;
    }
}