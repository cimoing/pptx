<?php

namespace Imoing\Pptx\Opc;


class ContentTypesItem
{
    private $parts;

    public function __construct(array $parts)
    {
        $this->parts = $parts;
    }

    public static function xmlFor(array $parts): \DOMDocument
    {
        return (new self($parts))->_xml();
    }

    private function _xml(): \DOMDocument
    {
        list($defaults, $overrides) = $this->_defaults_and_overrides();

        // Sort by extension and partname
        ksort($defaults);
        ksort($overrides);

        $dom = new \DOMDocument();
        $typesElm = $dom->createElement('Types');
        $typesElm->setAttribute('xmlns', 'http://schemas.openxmlformats.org/package/2006/content-types');
        $dom->appendChild($typesElm);

        foreach ($defaults as $ext => $contentType) {
            $defaultElm = $dom->createElement('Default');
            $defaultElm->setAttribute('Extension', $ext);
            $defaultElm->setAttribute('ContentType', $contentType);
            $typesElm->appendChild($defaultElm);
        }

        foreach ($overrides as $partname => $contentType) {
            $overrideElm = $dom->createElement('Override');
            $overrideElm->setAttribute('PartName', (string)$partname);
            $overrideElm->setAttribute('ContentType', $contentType);
            $typesElm->appendChild($overrideElm);
        }

        return $dom;
    }

    private function _defaults_and_overrides(): array
    {
        // Default content types as associative array
        $defaults = [
            'rels' => 'application/vnd.openxmlformats-package.relationships+xml',
            'xml' => 'application/xml',
        ];

        $overrides = [];

        foreach ($this->parts as $part) {
            $partName = $part->partName; // Assuming Part object has a partname property
            $contentType = $part->getContentType(); // Assuming Part object has a content_type property

            $ext = $partName->ext; // Assuming PackURI object has an ext property

            // Check if this is a default content type
            if (isset($defaults[$ext]) && $defaults[$ext] === $contentType) {
                continue;
            }

            // If not default, add to overrides
            $overrides[(string)$partName] = $contentType;
        }

        return [$defaults, $overrides];
    }
}
