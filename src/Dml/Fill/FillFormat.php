<?php

namespace Imoing\Pptx\Dml\Fill;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Dml\Color\ColorFormat;
use Imoing\Pptx\Enum\MsoFillType;
use Imoing\Pptx\OXml\Dml\Fill\AbsFill;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;


/**
 * @property-read MsoFillType $type
 * @property-read ColorFormat $foreColor
 * @property-read ColorFormat $backColor
 */
class FillFormat extends BaseObject
{
    /**
     * @var BaseOXmlElement
     */
    protected BaseOXmlElement $_xPr;
    protected Fill $_fill;
    public function __construct(BaseOXmlElement $egFillPropertiesParent, Fill $fill)
    {
        parent::__construct();
        $this->_fill = $fill;
        $this->_xPr = $egFillPropertiesParent;
    }

    public static function fromFillParent(BaseOXmlElement $egFillPropertiesParent): FillFormat
    {
        $fillElm = $egFillPropertiesParent->eg_fillProperties;
        $fill = Fill::create($fillElm);
        return new FillFormat($egFillPropertiesParent, $fill);
    }

    public function background(): void
    {
        $noFill = $this->_xPr->get_or_change_to_noFill();
        $this->_fill = new NoFill($noFill);
    }

    public function getBackColor(): ColorFormat
    {
        return $this->_fill->backColor;
    }

    public function getForeColor(): ColorFormat
    {
        return $this->_fill->foreColor;
    }

    public function solid(): void
    {
        $solidFill = $this->_xPr->get_or_change_to_solidFill();
        $this->_fill = new SolidFill($solidFill);
    }

    public function getType(): ?MsoFillType
    {
        return $this->_fill->type;
    }

    public function toArray(): array
    {
        return $this->_fill->toArray();
    }

    public function getFill(): Fill
    {
        return $this->_fill;
    }
}