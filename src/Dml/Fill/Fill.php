<?php

namespace Imoing\Pptx\Dml\Fill;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Dml\Color\ColorFormat;
use Imoing\Pptx\Enum\MsoFillType;
use Imoing\Pptx\OXml\Dml\Fill\CTBlipFillProperties;
use Imoing\Pptx\OXml\Dml\Fill\CTGradientFillProperties;
use Imoing\Pptx\OXml\Dml\Fill\CTGroupFillProperties;
use Imoing\Pptx\OXml\Dml\Fill\CTNoFillProperties;
use Imoing\Pptx\OXml\Dml\Fill\CTPatternFillProperties;
use Imoing\Pptx\OXml\Dml\Fill\CTSolidColorFillProperties;

/**
 * @property-read ?MsoFillType $type
 * @property-read ColorFormat $backColor
 * @property-read ColorFormat $foreColor
 * @property-read $pattern
 */
abstract class Fill extends BaseObject
{
    public static function create(mixed $xFill): Fill
    {
        $clsMap = [
            CTBlipFillProperties::class => BlipFill::class,
            CTGradientFillProperties::class => GradFill::class,
            CTGroupFillProperties::class => GrpFill::class,
            CTNoFillProperties::class => NoFill::class,
            CTPatternFillProperties::class => PattFill::class,
            CTSolidColorFillProperties::class => SolidFill::class,
        ];
        if (empty($xFill)) {
            $cls = NoneFill::class;
        } else {
            foreach($clsMap as $name => $target) {
                if ($xFill instanceof $name) {
                    $cls = $target;
                    break;
                }
            }
        }
        if (empty($cls)) {
            $cls = Fill::class;
        }

        return call_user_func([$cls, 'create'], $xFill);
    }

    abstract public function getType(): ?MsoFillType;

    /**
     * @return mixed
     */
    public function getBackColor(): ColorFormat
    {
        throw new \Exception(sprintf("fill type %s has no background color, call .patterned() first", __CLASS__));
    }

    /**
     * @return mixed
     */
    public function getForeColor(): ColorFormat
    {
        throw new \Exception(sprintf("fill type %s has no foreground color, call .solid() or .pattern ed() first", __CLASS__));
    }

    /**
     * @return mixed
     */
    public function getPattern()
    {
        throw new \Exception(sprintf("fill type %s has no pattern, call .patterned() first", __CLASS__));
    }

    abstract function toArray();
}