<?php

namespace Imoing\Pptx\OXml\Ns;

use DOMElement;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\FakeDomElement;

class NsMap
{
    public static array $map = [
        "a" => "http://schemas.openxmlformats.org/drawingml/2006/main",
        "c" => "http://schemas.openxmlformats.org/drawingml/2006/chart",
        "cp" => "http://schemas.openxmlformats.org/package/2006/metadata/core-properties",
        "ct" => "http://schemas.openxmlformats.org/package/2006/content-types",
        "dc" => "http://purl.org/dc/elements/1.1/",
        "dcmitype" => "http://purl.org/dc/dcmitype/",
        "dcterms" => "http://purl.org/dc/terms/",
        "ep" => "http://schemas.openxmlformats.org/officeDocument/2006/extended-properties",
        "i" => "http://schemas.openxmlformats.org/officeDocument/2006/relationships/image",
        "m" => "http://schemas.openxmlformats.org/officeDocument/2006/math",
        "mo" => "http://schemas.microsoft.com/office/mac/office/2008/main",
        "mv" => "urn:schemas-microsoft-com:mac:vml",
        "o" => "urn:schemas-microsoft-com:office:office",
        "p" => "http://schemas.openxmlformats.org/presentationml/2006/main",
        "pd" => "http://schemas.openxmlformats.org/drawingml/2006/presentationDrawing",
        "pic" => "http://schemas.openxmlformats.org/drawingml/2006/picture",
        "pr" => "http://schemas.openxmlformats.org/package/2006/relationships",
        "r" => "http://schemas.openxmlformats.org/officeDocument/2006/relationships",
        "sl" => "http://schemas.openxmlformats.org/officeDocument/2006/relationships/slideLayout",
        "v" => "urn:schemas-microsoft-com:vml",
        "ve" => "http://schemas.openxmlformats.org/markup-compatibility/2006",
        "w" => "http://schemas.openxmlformats.org/wordprocessingml/2006/main",
        "w10" => "urn:schemas-microsoft-com:office:word",
        "wne" => "http://schemas.microsoft.com/office/word/2006/wordml",
        "wp" => "http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing",
        "xsi" => "http://www.w3.org/2001/XMLSchema-instance",
    ];

    public static function getMap(): array
    {
        return self::$map;
    }

    private static $pfxMap = [];
    public static function getPfxMap(): array
    {
        if (empty(self::$pfxMap)) {
            $r = [];
            foreach (self::$map as $k => $v) {
                $r[$v] = $k;
            }
            self::$pfxMap = $r;
        }


        return self::$pfxMap;
    }

    public static function getNamespaceUri(string $_pfx): ?string
    {
        return self::$map[$_pfx] ?? null;
    }

    public static function getPrefix(string $nsuri): ?string
    {
        $map = self::getPfxMap();
        return $map[$nsuri] ?? null;
    }

    private static array $tagCls = [

    ];

    public static function getTagClass(string $tagName): string
    {
        if (empty($tagName)) {
            return BaseOXmlElement::class;
        }

        if (!str_contains($tagName, ':')) {
            $tagName = match ($tagName) {
                'Relationships' => 'pr:Relationships',
                'Relationship' => 'pr:Relationship',
                'Default' => 'ct:Default',
                default => 'ct:' . $tagName,
            };
        }

        $tag = new NamespacePrefixedTag($tagName);
        return self::$tagCls[$tag->getNsUri()][$tag->getLocalPart()] ?? BaseOXmlElement::class;
    }

    public static function registerTagClass(string $tagName, string $className): void
    {
        $tag = new NamespacePrefixedTag($tagName);
        self::$tagCls[$tag->getNsUri()][$tag->getLocalPart()] = $className;
    }

    public static function replaceTagClass(string $tagName, \DOMDocument $dom): void
    {

    }

    public static function castDom(DOMElement $element): BaseOXmlElement
    {
        $cls = self::getTagClass($element->tagName);
        return new $cls($element);
    }
}