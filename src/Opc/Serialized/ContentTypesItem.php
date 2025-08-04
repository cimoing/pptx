<?php

namespace Imoing\Pptx\Opc\Serialized;

use Imoing\Pptx\Opc\Part;

class ContentTypesItem
{
    /**
     * @var Part[]
     */
    private array $_parts;

    public function __construct(array $parts)
    {
        $this->_parts = $parts;
    }

    public static function xmlFor(array $parts)
    {

    }
}