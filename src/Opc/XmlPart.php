<?php

namespace Imoing\Pptx\Opc;

use Imoing\Pptx\IPackage;
use Imoing\Pptx\Opc\Part;
use Imoing\Pptx\OXml\Ns\NsMap;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\Package\Package;

/**
 * @property BaseOXmlElement $element
 */
abstract class XmlPart extends Part
{
    protected BaseOXmlElement $_element;
    public function __construct(PackURI $partName, string $contentType, Package $package, BaseOXmlElement $element)
    {
        parent::__construct($partName, $contentType, $package);
        $this->_element = $element;
    }

    protected static string $nsTag = '';
    public static function load(PackURI $partName, string $contentType, Package $package, string $blob): static
    {
        $dom = new \DOMDocument();
        NsMap::replaceTagClass(static::$nsTag, $dom);
        $dom->encoding = 'UTF-8';
        $dom->loadXML($blob);
        $element = $dom->documentElement;

        return new static($partName, $contentType, $package, NsMap::castDom($element));
    }

    public function getBlob(): string
    {
        return $this->_element->xml();
    }

    public function dropRel(string $rId): void
    {
        if ($this->relRefCount($rId) < 2) {
            $this->getRels()->pop($rId);
        }
    }

    protected function relRefCount(string $rId): int
    {
        $items = $this->_element->xpath("//@r:id");
        $count = 0;
        foreach ($items as $item) {
            if ($item instanceof \DOMAttr && $item->value === $rId) {
                $count++;
            }
        }

        return $count;
    }

    public function getElement(): BaseOXmlElement
    {
        return $this->_element;
    }
}