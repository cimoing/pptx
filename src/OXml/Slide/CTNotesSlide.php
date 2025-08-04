<?php

namespace Imoing\Pptx\OXml\Slide;

use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;
use Imoing\Pptx\Templates\Template;

/**
 * tag sequences: "p:cSld", "p:clrMapOvr", "p:extLst"
 */
class CTNotesSlide extends BaseSlideElement
{
    #[OneAndOnlyOne("p:cSld")]
    protected CTCommonSlideData $cSld;

    public static function create(): static
    {
        $obj = Template::parseFromTemplate("notes");
        assert($obj instanceof static);
        return $obj;
    }
}