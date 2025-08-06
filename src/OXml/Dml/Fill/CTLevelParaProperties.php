<?php

namespace Imoing\Pptx\OXml\Dml\Fill;

use Imoing\Pptx\Enum\PPParagraphAlignment;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;
use Imoing\Pptx\Util\Length;

/**
 * @property ?PPParagraphAlignment $algn
 */
class CTLevelParaProperties extends BaseOXmlElement
{
    #[OptionalAttribute("algn", PPParagraphAlignment::class, default: "l")]
    protected string $_algn;

    #[OptionalAttribute("defTabSz", Length::class)]
    protected ?Length $_defTabSz;
}