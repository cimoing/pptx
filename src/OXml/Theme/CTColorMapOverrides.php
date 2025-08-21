<?php

namespace Imoing\Pptx\OXml\Theme;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @property ?CTColorMap $overrideClrMapping
 */
class CTColorMapOverrides extends BaseOXmlElement
{
    #[ZeroOrOne("a:overrideClrMapping")]
    protected mixed $_overrideClrMapping;
}