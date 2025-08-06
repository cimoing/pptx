<?php

namespace Imoing\Pptx\OXml\Dml\Color;

use Imoing\Pptx\Enum\PrstClr;
use Imoing\Pptx\OXml\SimpleTypes\BaseStringType;
use Imoing\Pptx\OXml\SimpleTypes\XsdString;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;

/**
 * @property PrstClr $val
 */
class CTPresetColor extends BaseColorElement
{
    #[RequiredAttribute("val", PrstClr::class)]
    protected string $_val;

    public function getHexValue(): string
    {
        return $this->val->getColor();
    }
}