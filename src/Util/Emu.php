<?php

namespace Imoing\Pptx\Util;

use Imoing\Pptx\Util\Length;

class Emu extends Length
{
    public function __construct(int $emu)
    {
        parent::__construct($emu);
    }
}