<?php

namespace Imoing\Pptx\OXml\XmlChemy;

use Imoing\Pptx\OXml\Ns\NamespacePrefixedTag;
use Imoing\Pptx\OXml\Ns\NsMap;

class BaseOXmlElement extends MetaOXmlElement
{
    public function firstChildFoundIn(array $tagNames): ?BaseOXmlElement
    {
        foreach ($this->childNodes as $child) {
            if ($child instanceof \DOMElement && in_array($child->tagName, $tagNames)) {
                $item = $this->getElementsByNsTagName($child->tagName)->item(0);
                return NsMap::castDom($item);
            }
        }

        return null;
    }

    public function insertElementBefore(BaseOXmlElement $element, array $tagNames): BaseOXmlElement
    {
        $child = empty($tagNames) ? null : $this->firstChildFoundIn($tagNames);
        if ($child) {
            $this->insertBefore($element->element, $child->element);
        } else {
            $this->appendChild($element->element);
        }

        return $element;
    }

    /**
     * @param string $nsTagName
     * @return BaseOXmlElement[]
     */
    public function getDirectChildrenByNsTagName(string $nsTagName): array
    {
        $result = [];
        foreach ($this->childNodes as $child) {
            if ($child instanceof \DOMElement && $child->tagName == $nsTagName) {
                $result[] = NsMap::castDom($child);
            }
        }

        return $result;
    }

    public function getElementsByNsTagName(string $nsTagName): \DOMNodeList
    {
        $tag = $this->getTagByNsTagName($nsTagName);
        return $this->getElementsByTagNameNS($tag->getNsUri(), $tag->getLocalPart());
    }

    public function getTagByNsTagName(string $nsTagName): NamespacePrefixedTag
    {
        return new NamespacePrefixedTag($nsTagName);
    }

    public function xpath(string $xpath, string $nsTagName = ''): \DOMNodeList
    {
        $reader = new \DOMXPath($this->ownerDocument);

        if (!empty($nsTagName)) {
            $tag = new NamespacePrefixedTag($nsTagName);
            $namespaces = $tag->getNsmap();
        } else {
            $namespaces = NsMap::getPfxMap();
        }

        foreach ($namespaces as $prefix => $uri) {
            $reader->registerNamespace($prefix, $uri);
        }

        return $reader->query($xpath, $this->element);
    }

    public function xml(): string
    {
        return $this->ownerDocument->saveXML($this->element);
    }

    private ?\DOMDocument $_svgDocument = null;
    public function getSvgDocument(): \DOMDocument
    {
        if ($this->_svgDocument === null) {
            $this->_svgDocument = new \DOMDocument();
            $xml = "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"960\" height=\"720\" viewBox=\"0 0 960 720\"></svg>";
            $this->_svgDocument->loadXML($xml);
        }

        return $this->_svgDocument;
    }

    public function getSvgDom(): \DOMElement
    {
        throw new \Exception("not implemented");
    }

    public function svg(): string
    {
        throw new \Exception("not implemented");
    }

    public function __toString()
    {
        return $this->xml();
    }
}