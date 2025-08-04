<?php

namespace Imoing\Pptx\OXml\Action;

use Imoing\Pptx\OXml\SimpleTypes\XsdString;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;

/**
 * @property string $rId
 * @property string $action
 */
class CTHyperlink extends BaseOXmlElement
{
    #[OptionalAttribute("r:id", XsdString::class)]
    protected string $_rId;

    #[OptionalAttribute("action", XsdString::class)]
    protected ?string $_action;

    public function getActionFields(): array
    {
        $url = $this->__get('action');
        if (empty($url)) {
            return [];
        }

        $params = parse_url($url);
        return $params['query'] ?? [];
    }

    public function getActionVerb(): ?string
    {
        $url = $this->__get('action');
        if (empty($url)) {
            return null;
        }

        $endPos = strpos($url, '?');
        if ($endPos === false) {
            $endPos = strlen($url) - 1;
        }

        return substr($url, 11, $endPos - 12);
    }
}