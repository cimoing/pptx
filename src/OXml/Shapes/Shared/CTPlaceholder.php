<?php

namespace Imoing\Pptx\OXml\Shapes\Shared;

use Imoing\Pptx\Enum\PPPlaceholderType;
use Imoing\Pptx\OXml\SimpleTypes\STDirection;
use Imoing\Pptx\OXml\SimpleTypes\STPlaceholderSize;
use Imoing\Pptx\OXml\SimpleTypes\XsdUnsignedInt;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;

/**
 * @property PPPlaceholderType $type
 * @property string $orient
 * @property string $sz
 * @property int $idx
 */
class CTPlaceholder extends BaseOXmlElement
{
    #[OptionalAttribute("type", PPPlaceholderType::class, default: PPPlaceholderType::OBJECT)]
    protected PPPlaceholderType $_type;

    #[OptionalAttribute("orient", STDirection::class, default: STDirection::HORZ)]
    protected string $_orient;

    #[OptionalAttribute("sz", STPlaceholderSize::class, default: STPlaceholderSize::FULL)]
    protected string $_sz;

    #[OptionalAttribute("idx", XsdUnsignedInt::class, default: 0)]
    protected int $_idx;
}