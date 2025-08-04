<?php

namespace Imoing\Pptx\Opc\OXml;

use Imoing\Pptx\Opc\PackURI;
use Imoing\Pptx\OXml\Ns\NsMap;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrMore;

/**
 * @method  CTDefault _add_default(array $attrs = [])
 * @method  CTOverride _add_override(array $attrs = [])
 * @property CTDefault[] $default_lst
 * @property CTOverride[] $override_lst
 */
class CTTypes extends BaseOXmlElement
{
    #[ZeroOrMore("ct:Default")]
    protected array $_default;

    #[ZeroOrMore("ct:Override")]
    protected array $_override;

    /**
     * @return CTTypes
     * @throws \DOMException
     */
    public static function create(): CTTypes
    {
        $dom = new \DOMDocument();
        $dom->encoding = "UTF-8";
        NsMap::replaceTagClass("ct:Types", $dom);
        $element = $dom->createElement("Types");
        assert($element instanceof static);
        $uri = NsMap::getNamespaceUri("ct");
        $element->setAttribute("xmlns", $uri);

        return $element;
    }

    public function addDefault(string $ext, string $contentType): CTDefault
    {
        return $this->_add_default([
            'extension' => $ext,
            'contentType' => $contentType,
        ]);
    }

    public function addOverride(PackURI $partName, string $contentType): CTOverride
    {
        return $this->_add_override([
            'partName' => (string) $partName,
            'contentType' => $contentType,
        ]);
    }
}