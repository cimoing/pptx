<?php

namespace Imoing\Pptx\Opc\Package;

use Imoing\Pptx\Opc\OXml\CTTypes;
use Imoing\Pptx\Opc\PackURI;

class ContentTypeMap
{
    private array $_overrides = [];

    private array $_defaults = [];
    public function __construct(array $overrides, array $defaults)
    {
        $this->_overrides = $overrides;
        $this->_defaults = $defaults;
    }

    public function getItem(PackURI $partName): string
    {
        $str = strtolower((string) $partName);
        if (isset($this->_overrides[$str])) {
            return $this->_overrides[$str];
        }

        $ext = $partName->getExt();
        if (isset($this->_defaults[$ext])) {
            return $this->_defaults[$ext];
        }
        throw new \Exception("No content type found for part $str in [Content_Types].xml");
    }
    public static function fromXml(string $xml): static
    {
        /**
         * @var CTTypes $element
         */
        $element = parseXml('ct:Types', $xml);
        $defaults = [];
        $overrides = [];

        foreach ($element->override_lst as $item) {
            $overrides[strtolower($item->partName)] = $item->contentType;
        }

        foreach ($element->default_lst as $item) {
            $defaults[strtolower($item->extension)] = $item->contentType;
        }


        return new static($overrides, $defaults);
    }
}