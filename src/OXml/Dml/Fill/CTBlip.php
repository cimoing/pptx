<?php

namespace Imoing\Pptx\OXml\Dml\Fill;

use Imoing\Pptx\OXml\SimpleTypes\STRelationshipId;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;

/**
 * @property ?string $rEmbed
 */
class CTBlip extends BaseOXmlElement
{
    #[OptionalAttribute("r:embed", STRelationshipId::class)]
    protected string $_rEmbed;
}