<?php

namespace Imoing\Pptx\Shapes;

use Imoing\Pptx\Enum\MsoAutoShapeType;
use Imoing\Pptx\Enum\MsoShapeType;
use Imoing\Pptx\OXml\Shapes\Connector\CTConnector;
use Imoing\Pptx\Shapes\AutoShape\Shape;
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

    public function getLineArr(): array
    {
        $shapeType = $this->_connector->spPr->prstGeom->prst->getXmlValue();
        $start = $end = [0, 0];
        $isFlipV = $this->flipV;
        $isFlipH = $this->flipH;
        $width = $this->getWidth()->pt;
        $height = $this->getHeight()->pt;
        if (!$isFlipV && !$isFlipH) {
            $end = [$width, $height];
        } else if ($isFlipV && $isFlipH) {
            $start = [$width, $height];
        } else if ($isFlipV && !$isFlipH) {
            $start = [0, $height];
            $end = [$width, 0];
        } else {
            $start = [$width, 0];
            $end = [0, $height];
        }

        $rot = $this->rotation;

        $data = [
            'type' => 'line',
            'left' => $this->getLeft()->px,
            'top' => $this->getTop()->px,
            'start' => $start,
            'end' => $end,
            'points' => ['', $shapeType == MsoAutoShapeType::LINE_INVERSE->getXmlValue() ? 'arrow' : ''],
        ];
        if ($rot != 0) {
            $data = $this->rotateLine($data, $rot);
        }

        if (str_contains($shapeType, 'bentConnector')) {
            $data['broken2'] = [
                abs(($data['start'][0] - $data['end'][0]) / 2),
                abs(($data['start'][1] - $data['end'][1]) / 2)
            ];
        }

        if (str_contains($shapeType, 'curvedConnector')) {
            $cubic = [
                abs(($data['start'][0] - $data['end'][0]) / 2),
                abs(($data['start'][1] - $data['end'][1]) / 2)
            ];
            $data['cubic'] = [$cubic, $cubic];
        }

        return array_merge($data, $this->getOutlineArr());
    }

    private function rotateLine(array $data, $angleDeg): array
    {
        $start = $data['start'];

        $end = $data['end'];


        $angleRad = $angleDeg * M_PI / 180;


        $midX = ($start[0] + $end[0]) / 2;
        $midY = ($start[1] + $end[1]) / 2;

        $startTransX = $start[0] - $midX;
        $startTransY = $start[1] - $midY;
        $endTransX = $end[0] - $midX;
        $endTransY = $end[1] - $midY;

        $cosA = cos($angleRad);
        $sinA = sin($angleRad);

        $startRotX = $startTransX * $cosA - $startTransY * $sinA;
        $startRotY = $startTransX * $sinA + $startTransY * $cosA;

        $endRotX = $endTransX * $cosA - $endTransY * $sinA;
        $endRotY = $endTransX * $sinA + $endTransY * $cosA;

        $startNewX = $startRotX + $midX;
        $startNewY = $startRotY + $midY;
        $endNewX = $endRotX + $midX;
        $endNewY = $endRotY + $midY;

        $beforeMinX = min($start[0], $end[0]);
        $beforeMinY = min($start[1], $end[1]);

        $afterMinX = min($startNewX, $endNewX);
        $afterMinY = min($startNewY, $endNewY);

        $startAdjustedX = $startNewX - $afterMinX;
        $startAdjustedY = $startNewY - $afterMinY;
        $endAdjustedX = $endNewX - $afterMinX;
        $endAdjustedY = $endNewY - $afterMinY;

        $startAdjusted = [$startAdjustedX, $startAdjustedY];
        $endAdjusted = [$endAdjustedX, $endAdjustedY];
        $offset = [$afterMinX - $beforeMinX, $afterMinY - $beforeMinY];

        $data['start'] = $startAdjusted;
        $data['end'] = $endAdjusted;
        $data['left'] += $offset[0];
        $data['top'] += $offset[1];

        return $data;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), $this->getLineArr());
    }
}