<?php

namespace Imoing\Pptx\Shapes;

use Imoing\Pptx\Dml\Line\LineFormat;
use Imoing\Pptx\Enum\MsoAutoShapeType;
use Imoing\Pptx\Enum\MsoShapeType;
use Imoing\Pptx\OXml\Shapes\Connector\CTConnector;
use Imoing\Pptx\Shapes\Base\BaseShape;
use Imoing\Pptx\Types\ProvidesPart;

class Connector extends BaseShape
{
    private CTConnector $_connector;
    public function __construct(CTConnector $shape, ProvidesPart $parent)
    {
        parent::__construct($shape, $parent);
        $this->_connector = $shape;
    }
    public function getShapeType(): MsoShapeType
    {
        return MsoShapeType::LINE;
    }

    public function getLine(): LineFormat
    {
        return new LineFormat($this->_connector->spPr);
    }

    public function getSchemeColor(string $scheme): ?string
    {
        return $this->_parent->getSchemeColor($scheme);
    }

    public function getAutoShapeType(): ?MsoAutoShapeType
    {
        return $this->_connector->spPr->prstGeom->prst;
    }

    public function getLineArr(): array
    {
        $data = parent::getLineArr();

        $outline = $this->getLine()->toArray();
        $outline['color'] = $this->colorToString($outline['color'] ?? null);

        $data['width'] = $outline['width'] ?: 1;
        $data['color'] = $outline['color'];
        $data['style'] = $outline['style'];

        return $data;
    }

    public function toArray(): array
    {
        $arr = $this->getLineArr();
        unset($arr['rotate']);

        return $arr;
    }
}