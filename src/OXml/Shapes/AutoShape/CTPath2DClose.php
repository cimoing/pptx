<?php

namespace Imoing\Pptx\OXml\Shapes\AutoShape;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;

class CTPath2DClose extends BaseOXmlElement
{
    public function getCommand(): string
    {
        return 'z';
    }

    public function getPtLst(): array
    {
        return [];
    }

    public function getPointArray(): array
    {
        return [
            'close' => true,
            'type' => $this->getCommand(),
        ];
    }
}