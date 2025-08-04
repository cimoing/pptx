<?php

namespace Imoing\Pptx\Dml\Fill;

use Imoing\Pptx\Dml\Color\ColorFormat;
use Imoing\Pptx\Enum\MsoFillType;
use Imoing\Pptx\OXml\Dml\Fill\CTGradientFillProperties;
use Imoing\Pptx\OXml\Dml\Fill\CTGradientStop;
use Imoing\Pptx\OXml\Dml\Fill\CTGradientStopList;

/**
 * @property ?float $gradientAngle
 * @property-read array $gradientStops
 */
class GradFill extends Fill
{
    protected $_element;

    /**
     * @var mixed|CTGradientFillProperties
     */
    protected $_gradFill;
    public function __construct($gradFill)
    {
        parent::__construct();
        $this->_element = $this->_gradFill = $gradFill;
    }

    public function getGradientAngle(): ?float
    {
        $path = $this->_gradFill->path;
        if (is_null($path)) {
            throw new \Exception("not a linear gradient");
        }

        $lin = $this->_gradFill->lin;
        if (is_null($lin)) {
            return null;
        }

        $clockWiseAngle = $lin->ang;
        return $clockWiseAngle == 0.0 ? 0.0 : (360.0 - $clockWiseAngle);
    }

    public function setGradientAngle(float $angle): void
    {
        $lin = $this->_gradFill->lin;
        if (is_null($lin)) {
            throw new \Exception("not a linear gradient");
        }

        $lin->ang = 360.0 - $angle;
    }

    /**
     * @var CTGradientStop[]|null
     */
    private ?array $_gradientStops = null;
    public function gradientStops(): array
    {
        if (empty($this->_gradientStops)) {
            $this->_gradientStops = $this->_gradFill->get_or_add_gsLst()->gs;
        }

        return $this->_gradientStops;
    }

    public function getType(): ?MsoFillType
    {
        return MsoFillType::GRADIENT;
    }

    public function toArray(): array
    {
        return [
            'type' => 'gradient',
            'value' => [
                'rot' => $this->gradientAngle ?: 0,
                'path' => $this->_gradFill->lin ? 'line' : ($this->_gradFill->path ?? ''),
                'colors' => $this->_gradFill->gsLst ? array_map(function ($gs) {
                    $color = ColorFormat::fromColorChoiceParent($gs);
                    return [
                        'pos' => $gs->pos,
                        'color' => (string) $color->getRgb(),
                    ];
                }, $this->_gradFill->gsLst->gs) : [],
            ],
        ];
    }
}