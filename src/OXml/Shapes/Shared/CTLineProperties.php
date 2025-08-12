<?php

namespace Imoing\Pptx\OXml\Shapes\Shared;

use Imoing\Pptx\Enum\MsoLineDashStyle;
use Imoing\Pptx\OXml\Dml\Fill\AbsFill;
use Imoing\Pptx\OXml\Dml\Line\CTPresetLineDashProperties;
use Imoing\Pptx\OXml\SimpleTypes\STLineWidth;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\Choice;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOneChoice;
use Imoing\Pptx\Util\Emu;
use Imoing\Pptx\Util\Length;

/**
 * @property Length $w
 * @property ?AbsFill $eg_lineFillProperties
 * @property ?AbsFill $eg_fillProperties
 * @property ?CTPresetLineDashProperties $prstDash
 * @property $custDash
 * @property ?MsoLineDashStyle $prstDashVal
 * @method void _remove_prstDash()
 * @method void _remove_custDash()
 */
class CTLineProperties extends BaseOXmlElement
{
    #[ZeroOrOneChoice(choices:[
        new Choice("a:noFill"),
        new Choice("a:solidFill"),
        new Choice("a:gradFill"),
        new Choice("a:pattFill"),
    ], successors: [
        "a:prstDash",
        "a:custDash",
        "a:round",
        "a:bevel",
        "a:miter",
        "a:headEnd",
        "a:tailEnd",
        "a:extLst",
    ])]
    protected mixed $_eg_lineFillProperties;

    #[ZeroOrOne("a:prstDash", successors: [
        "a:custDash",
        "a:round",
        "a:bevel",
        "a:miter",
        "a:headEnd",
        "a:tailEnd",
        "a:extLst",
    ])]
    protected mixed $_prstDash;

    #[ZeroOrOne("a:custDash", successors: [
        "a:custDash",
        "a:round",
        "a:bevel",
        "a:miter",
        "a:headEnd",
        "a:tailEnd",
        "a:extLst",
    ])]
    protected mixed $_custDash;

    #[OptionalAttribute("w", STLineWidth::class, default: new Emu(0))]
    protected mixed $_w;

    public function getEg_fillProperties()
    {
        return $this->eg_lineFillProperties;
    }

    public function getPrstDashVal()
    {
        $prstDash = $this->prstDash;
        if (empty($prstDash)) {
            return null;
        }

        return $prstDash->val;
    }

    public function setPrstDashVal($val): void
    {
        $this->_remove_custDash();
        $prstDash = $this->get_or_add_prstDash();
        $prstDash->val = $val;
    }
}