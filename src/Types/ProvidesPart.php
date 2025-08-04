<?php

namespace Imoing\Pptx\Types;

use Imoing\Pptx\Opc\XmlPart;

interface ProvidesPart
{
    public function getPart(): XmlPart;
}