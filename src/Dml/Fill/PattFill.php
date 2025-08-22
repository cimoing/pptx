<?php

namespace Imoing\Pptx\Dml\Fill;

use Imoing\Pptx\Dml\Color\ColorFormat;
use Imoing\Pptx\Enum\MsoFillType;
use Imoing\Pptx\OXml\Dml\Fill\CTPatternFillProperties;
use Imoing\Pptx\Shapes\Base\Theme;

class PattFill extends Fill
{
    /**
     * @var mixed|CTPatternFillProperties
     */
    protected mixed $_pattFill;
    protected $_element;
    public function __construct($pattFill, ?Theme $theme = null)
    {
        parent::__construct($pattFill, $theme);
        $this->_element = $this->_pattFill = $pattFill;
    }

    private ?ColorFormat $_backColor = null;
    public function getBackColor(): ColorFormat
    {
        if (is_null($this->_backColor)) {
            $bgClr = $this->_pattFill->get_or_add_bgClr();
            $this->_backColor = ColorFormat::fromColorChoiceParent($bgClr, $this->_theme);
        }


        return $this->_backColor;
    }

    protected ?ColorFormat $_foreColor = null;
    public function getForeColor(): ColorFormat
    {
        if (is_null($this->_foreColor)) {
            $fgClr = $this->_pattFill->get_or_add_fgClr();
            $this->_foreColor = ColorFormat::fromColorChoiceParent($fgClr, $this->_theme);
        }

        return $this->_foreColor;
    }

    public function getType(): ?\Imoing\Pptx\Enum\MsoFillType
    {
        return MsoFillType::PATTERNED;
    }
}