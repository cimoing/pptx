<?php

namespace Imoing\Pptx\OXml\Dml\Fill;

class CTNoFillProperties extends AbsFill
{
    public function getJsonType(): string
    {
        return 'NO_FILL';
    }
}