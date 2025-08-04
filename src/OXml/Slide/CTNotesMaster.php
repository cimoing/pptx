<?php

namespace Imoing\Pptx\OXml\Slide;

use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;
use Imoing\Pptx\Templates\Template;

/**
 * tag sequences: "p:cSld", "p:clrMap", "p:hf", "p:notesStyle", "p:extLst"
 */
class CTNotesMaster extends BaseSlideElement
{
    #[OneAndOnlyOne("p:cSld")]
    protected CTCommonSlideData $cSld;

    public static function createDefault(): static
    {
        $obj = Template::parseFromTemplate("notesMaster");

        assert($obj instanceof self);
        return $obj;
    }
}