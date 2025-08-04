<?php

namespace Imoing\Pptx\OXml\Text;

use Imoing\Pptx\Enum\MsoAutoSize;
use Imoing\Pptx\Enum\MsoVerticalAnchor;
use Imoing\Pptx\OXml\SimpleTypes\STCoordinate32;
use Imoing\Pptx\OXml\SimpleTypes\STTextWrappingType;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\Choice;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOneChoice;
use Imoing\Pptx\Util\Emu;
use Imoing\Pptx\Util\Length;

/**
 * @method BaseOXmlElement _add_noAutofit()
 * @method CTTextNormalAutofit _add_normAutofit()
 * @method BaseOXmlElement _add_spAutoFit()
 * @method void _remove_eg_textAutoFit()
 * @property ?BaseOXmlElement $noAutofit
 * @property ?CTTextNormalAutofit $normAutofit
 * @property ?BaseOXmlElement $spAutoFit
 * @property Length $lIns
 * @property Length $tIns
 * @property Length $rIns
 * @property Length $bIns
 * @property ?string $wrap
 */
class CTTextBodyProperties extends BaseOXmlElement
{
    #[ZeroOrOneChoice([
        new Choice("a:noAutofit"),
        new Choice("a:normAutofit"),
        new Choice("a:spAutoFit"),
    ], successors: ["a:scene3d", "a:sp3d", "a:flatTx", "a:extLst"])]
    protected string $_eg_textAutoFit;

    #[OptionalAttribute("lIns", STCoordinate32::class, default: new Emu(91440))]
    protected Length $_lIns;

    #[OptionalAttribute("tIns", STCoordinate32::class, default: new Emu(45720))]
    protected Length $_tIns;

    #[OptionalAttribute("rIns", STCoordinate32::class, default: new Emu(91440))]
    protected Length $_rIns;

    #[OptionalAttribute("bIns", STCoordinate32::class, default: new Emu(45720))]
    protected Length $_bIns;

    #[OptionalAttribute("anchor", MsoVerticalAnchor::class)]
    protected ?MsoVerticalAnchor $anchor;

    #[OptionalAttribute("wrap", STTextWrappingType::class)]
    protected ?string $_wrap;

    public function getAutofit(): ?MsoAutoSize
    {
        if ($this->noAutofit) {
            return MsoAutoSize::NONE;
        }

        if ($this->normAutofit) {
            return MsoAutoSize::TEXT_TO_FIT_SHAPE;
        }

        if ($this->spAutoFit) {
            return MsoAutoSize::SHAPE_TO_FIT_TEXT;
        }

        return null;
    }

    public function setAutofit(?MsoAutoSize $val): void
    {
        $this->_remove_eg_textAutoFit();;
        match ($val) {
            MsoAutoSize::NONE => $this->_add_noAutofit(),
            MsoAutoSize::TEXT_TO_FIT_SHAPE => $this->_add_normAutofit(),
            MsoAutoSize::SHAPE_TO_FIT_TEXT => $this->_add_spAutoFit(),
            MsoAutoSize::MIXED => '',
        };
    }
}