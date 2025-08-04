<?php

namespace Imoing\Pptx\OXml\Shapes\Shared;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @method CTPlaceholder get_or_add_ph()
 */
class CTApplicationNonVisualDrawingProps extends BaseOXmlElement
{
    #[ZeroOrOne("p:ph", successors: [
        "a:audioCd",
        "a:wavAudioFile",
        "a:audioFile",
        "a:videoFile",
        "a:quickTimeFile",
        "p:custDataLst",
        "p:extLst",
    ])]
    protected ?CTPlaceholder $_ph;
}