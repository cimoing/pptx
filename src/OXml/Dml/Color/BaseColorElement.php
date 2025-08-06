<?php

namespace Imoing\Pptx\OXml\Dml\Color;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @property ?CTPercentage $lumMod
 * @property ?CTPercentage $lumOff
 */
class BaseColorElement extends BaseOXmlElement
{
    #[ZeroOrOne("a:lumMod")]
    protected mixed $_lumMod;

    #[ZeroOrOne("a:lumOff")]
    protected mixed $l_umOff;

    public function add_lumMod($value)
    {
        $lumMod = $this->_add_lumMod();
        $lumMod->val = $value;

        return $lumMod;
    }

    public function add_lumOff($value)
    {
        $lumOff = $this->_add_lumOff();
        $lumOff->val = $value;
        return $lumOff;
    }

    public function clear_lum(): self
    {
        $this->_remove_lumMod();
        $this->_remove_lumOff();
        return $this;
    }

    public function getJsonValue(): mixed
    {
        return '#fff';
    }

    public function getHexValue(): string
    {
        return '';
    }
}