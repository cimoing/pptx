<?php

namespace Imoing\Pptx\Shapes;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Opc\Package\XmlPart;
use Imoing\Pptx\Types\ProvidesPart;

/**
 * @property XmlPart $part
 */
class Subshape extends BaseObject implements ProvidesPart
{
    protected ProvidesPart $_parent;
    public function __construct(ProvidesPart $part)
    {
        parent::__construct([]);
        $this->_parent = $part;
    }

    public function getPart(): XmlPart
    {
        return $this->_parent->getPart();
    }
}