<?php

namespace Imoing\Pptx\Dml\Fill;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Dml\Color\ColorFormat;
use Imoing\Pptx\Enum\MsoFillType;
use Imoing\Pptx\OXml\Dml\Fill\AbsFill;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\Shapes\Base\Theme;


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
    protected ?BaseOXmlElement $_xPr;
    protected Fill $_fill;

    protected ?Theme $_theme;
    public function __construct(?BaseOXmlElement $egFillPropertiesParent, Fill $fill, ?Theme $theme = null)
    {
        parent::__construct();
        $this->_fill = $fill;
        $this->_xPr = $egFillPropertiesParent;
        $this->_theme = $theme;
    }

    public static function fromFillParent(BaseOXmlElement $egFillPropertiesParent, ?Theme $theme = null): FillFormat
    {
        $fillElm = $egFillPropertiesParent->eg_fillProperties;
        $fill = Fill::create($fillElm, $theme);
        return new FillFormat($egFillPropertiesParent, $fill, $theme);
    }

    public static function fromRef(Theme $theme, int $idx, array $schemeClrLst = []): FillFormat
    {
        $fill = $theme->getFill($idx, $schemeClrLst);

        return new FillFormat(null, $fill, $theme);
    }

    public function background(): void
    {
        $noFill = $this->_xPr->get_or_change_to_noFill();
        $this->_fill = new NoFill($noFill, $this->_theme);
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
        $this->_fill = new SolidFill($solidFill, $this->_theme);
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