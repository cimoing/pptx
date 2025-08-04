<?php

namespace Imoing\Pptx\OXml\Text;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;
use Imoing\Pptx\Util\Length;

/**
 * @method CTTextSpacingPercent get_or_add_spcPct()
 * @method CTTextSpacingPoint get_or_add_spcPts()
 * @method void _remove_spcPct()
 * @method void _remove_spcPts()
 */
class CTTextSpacing extends BaseOXmlElement
{
    #[ZeroOrOne("a:spcPct")]
    protected ?CTTextSpacingPercent $spcPec;

    #[ZeroOrOne("a:spcPts")]
    protected ?CTTextSpacingPoint $spcPts;

    public function set_spcPct(float $val): void
    {
        $this->_remove_spcPts();;
        $spcPct = $this->get_or_add_spcPct();
        $spcPct->nodeValue = $val;
    }

    public function set_spcPts(Length $val): void
    {
        $this->_remove_spcPct();
        $spcPts = $this->get_or_add_spcPts();
        $spcPts->nodeValue = $val->getPt();
    }
}