<?php

namespace Imoing\Pptx\OXml\Theme;

use Imoing\Pptx\OXml\Shapes\Shared\CTLineProperties;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrMore;

/**
 * @property CTLineProperties[] $ln_lst
 */
class CTLineStyleList extends BaseOXmlElement
{
    #[ZeroOrMore("a:ln")]
    protected array $_ln;
}