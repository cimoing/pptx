<?php

namespace Imoing\Pptx\OXml\Theme;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\OXml\Slide\CTBackgroundRef;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

class CTStyle extends BaseObject
{
    #[ZeroOrOne("a:lnRef")]
    protected ?CTBackgroundRef $_lnRef;

    #[ZeroOrOne("a:fillRef")]
    protected ?CTBackgroundRef $_fillRef;

    #[ZeroOrOne("a:effectRef")]
    protected ?CTBackgroundRef $_effectRef;

    #[ZeroOrOne("a:fontRef")]
    protected ?CTBackgroundRef $_fontRef;
}