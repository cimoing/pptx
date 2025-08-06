<?php

namespace Imoing\Pptx\Types;

use Imoing\Pptx\Opc\Package\XmlPart;

interface ProvidesPart
{
    public function getPart(): XmlPart;
}