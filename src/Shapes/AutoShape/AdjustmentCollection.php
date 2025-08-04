<?php

namespace Imoing\Pptx\Shapes\AutoShape;

use Imoing\Pptx\OXml\Shapes\AutoShape\CTGeomGuide;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTPresetGeometry2D;

class AdjustmentCollection implements \Countable
{
    /**
     * @var Adjustment[]
     */
    protected array $_adjustments = [];
    protected CTPresetGeometry2D $_prstGeom;
    public function __construct(CTPresetGeometry2D $prstGeom)
    {
        $this->_adjustments = self::initAdjustments($prstGeom);
        $this->_prstGeom = $prstGeom;
    }

    public function getItem(int $idx): float
    {
        return $this->_adjustments[$idx]->effectiveValue;
    }

    public function setItem(int $idx, float $value): void
    {
        $this->_adjustments[$idx]->effectiveValue = $value;
        $this->rewriteGuides();
    }

    private function initAdjustments(?CTPresetGeometry2D $prstGeom): array
    {
        if (is_null($prstGeom)) {
            return [];
        }

        $avLst = AutoShapeType::defaultAdjustmentValues($prstGeom->prst);
        $adjustments = array_map(function ($adjustment) {
            return new Adjustment($adjustment[0], $adjustment[1]);
        }, $avLst);

        self::updateAdjustmentsWithActuals($adjustments, $prstGeom->gdLst);

        return $adjustments;
    }

    private function rewriteGuides(): void
    {
        $guides = array_map(function ($adjustment) {
            return ['name' => $adjustment->name, 'value' => $adjustment->value];
        }, $this->_adjustments);

        $this->_prstGeom->rewriteGuides($guides);
    }

    /**
     * @param Adjustment[] $adjustments
     * @param CTGeomGuide[] $guides
     * @return void
     */
    private static function updateAdjustmentsWithActuals(array $adjustments, array $guides): void
    {
        $adjustmentsByName = [];;
        foreach ($adjustments as $adjustment) {
            $adjustmentsByName[$adjustment->name] = $adjustment;
        }

        foreach ($guides as $guide) {
            $name = $guide->name;
            $fmla = $guide->fmla;
            $actual = intval(substr($fmla, 4 - strlen($fmla)));
            if (isset($adjustmentsByName[$name])) {
                $adjustmentsByName[$name]->actual = $actual;
            }
        }
    }

    public function count(): int
    {
        return count($this->_adjustments);
    }
}