<?php

namespace Imoing\Pptx\Dml\Effect;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\OXml\Shapes\Shared\CTShapeProperties;

/**
 * @property bool $inherit
 */
class ShadowFormat extends BaseObject
{
    /**
     * @var mixed|CTShapeProperties
     */
    protected mixed $_element;
    public function __construct($spPr)
    {
        parent::__construct([]);
        $this->_element = $spPr;
    }

    public function getInherit(): bool
    {
        if (empty($this->_element->effectLst)) {
            return true;
        }

        return false;
    }

    public function setInherit(bool $inherit): void
    {
        if ($inherit) {
            $this->_element->_remove_effectLst();
        } else {
            $this->_element->get_or_add_effectLst();
        }
    }
}